<?php
    function message(string $page = "details"): string
    {
        $color = "success";
        $message = match ($page) {
            "details" => "Name ",
            "address" => "Address ",
            "login" => "Email ",
            default => ""
        };
        if(isset($_GET['success']))
        {
            if($_GET['success']=="d") $message = "Address deleted successfully";
            elseif($_GET['success']=="p") $message = "Password changed successfully";
            else $message .= "updated successfully";
        }
        elseif(isset($_GET['failure']))
        {
            if($_GET['failure'] == 1) $message = "The entered data is invalid";
            elseif ($_GET['failure'] == 2) $message = "The entered password is incorrect";
            elseif ($_GET['failure'] == 3) $message = "Nothing to delete";
            elseif ($_GET['failure'] == 4) $message = "Passwords are not the same";
            else $message = "An error occurred";
            $color = "danger";
        }
        else return "";
        return '<script id="message_script">document.getElementById("message").innerHTML = 
                `<div class="alert alert-'.$color.' alert-dismissible fade show" role="alert">'.$message.'<button 
                type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`
                document.getElementById("message_script").remove()
                </script>';
    }

    function confirm_window(string $mode, string $path, bool $password_protect = false): string
    {
        $password_input = '';
        if($password_protect)
            $password_input = '<br><strong>Confirm with your password</strong>
                <div class="d-flex justify-content-center">
                    <input type="password" name="confirm_password" class="form-control form-control-lg w-75"
                     style="margin: 10px;" required>
                </div>';
        return
        '<div class="modal fade" tabindex="-1" id="confirmation_window" data-bs-backdrop="static" data-bs-keyboard="false" 
                aria-labelledby="confirmation_window" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-dark">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" style="font-size: 22px;">Are you sure you want to delete the '.$mode.'?</h5>
                    </div>
                    <form action="/TechTronic/'.$path.'" method="post">
                        <div class="modal-body" style="font-size: 19px;">
                            <p>This action is irreversible and you will not be able to restore your data.</p>
                            '.$password_input.'
                        </div>
                        <div class="modal-footer d-flex justify-content-evenly">
                            <input type="hidden" name="control_val" value="set">
                            <button type="button" class="btn btn-lg btn-secondary" style="width: 45%;" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-lg btn-danger" style="width: 45%;">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>';
    }

    function address(object $conn): string
    {
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/states.php");
        $states_data_list = get_data_list($states);
        $js_array = json_encode($states);

        $current_data = $conn->get_data("SELECT a.*,st.state_name FROM users u LEFT JOIN address a USING (address_id) LEFT JOIN us_states st USING (state_id)
                WHERE user_id={$_SESSION['user_id']}")[0];
        $phone = $current_data->phone_number ?? "";
        $street = str_replace("'","&#39;",$current_data->street ?? "");
        $city = str_replace("'","&#39;",$current_data->city ?? "");
        $state = $current_data->state_name ?? "";
        $zip = $current_data->zip ?? "";
        if($phone or $street or $city or $state or $zip) $delete_button =
            "<div class='col-12'>
                <button style='width: 100%; margin-top: 30px;' class='btn btn-outline-danger btn-lg' 
                    data-bs-toggle='modal' data-bs-target='#confirmation_window'>Delete</button>
             </div>";
        else $delete_button = "";

        return "<div id='address_form_container' class='text-dark bg-light'>
                <h2>Your address</h2>
                <form class='row g-3' id='address_form' method='post' action='/TechTronic/scripts/update_address.php'>
                    <div class='col-12'>
                        <label for='phone' class='form-label'>Phone number</label>
                        <input type='tel' class='form-control form-control-lg' id='phone' placeholder='337-240-9882' name='phone'
                               maxlength='12' pattern='^\d{3}-\d{3}-\d{4}$' title='Please use 012-345-6789 format' value='$phone' required>
                    </div>
                    <div class='col-12'>
                        <label for='street' class='form-label'>Street</label>
                        <input type='text' class='form-control form-control-lg' id='street' placeholder='3124 Sherwood Circle' 
                            maxlength='80' name='street' value='$street' required>
                    </div>
                    <div class='col-md-12'>
                        <label for='city' class='form-label'>City</label>
                        <input type='text' class='form-control form-control-lg' id='city' placeholder='Lake Charles' name='city'
                        pattern=\"^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$\" maxlength='50' value='$city' required>
                    </div>
                    <div class='col-md-8'>
                        <label for='state' class='form-label'>State</label>
                        <input class='form-control form-control-lg' list='states_list' id='state' name='state'
                            placeholder='Select a state...' value='$state' required>
                            <div id=\"state-feedback\" class=\"invalid-feedback\" style='font-size: 20px;'>
                                Please choose a valid state.
                            </div>
                        $states_data_list
                    </div>
                    <div class='col-md-4'>
                        <label for='zip' class='form-label'>Zip Code</label>
                        <input type='text' class='form-control form-control-lg' id='zip' placeholder='70601' maxlength='5'
                               pattern='^\d{5}$' name='zip_code' value='$zip' required>
                    </div>
                    <div class='col-12'>
                        <button type='submit' class='btn btn-success btn-lg w-100' style='margin-top: 20px;'>Update</button>
                    </div>
                </form>
                $delete_button
            </div>
            <script>const states_array = $js_array</script>
            <script src='/TechTronic/scripts/JS/validate_address_form.js'></script>
            ".confirm_window("address", "scripts/delete_address.php");
    }

    function details(object $conn): string
    {
        $user_details = $conn->get_data("SELECT first_name,last_name FROM users WHERE user_id = ".$_SESSION['user_id'])[0];
        $first_name = $user_details->first_name;
        $last_name = $user_details->last_name;
        return '<div id="user_details_form" class="text-dark bg-light">
                <form action="/TechTronic/scripts/update_user_name.php" method="post">
                    <h2>Your Details</h2>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control form-control-lg" name="first_name" id="first_name" value="'.$first_name.'"
                               placeholder=" " pattern="^[\w\'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&quot;&*(){}|~<>;:[\]]{1,99}$" required
                               title="Do not use special characters or numbers. First name should have at least 2 letters.">
                        <label for="first_name">First Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control form-control-lg" name="last_name" id="last_name" value="'.$last_name.'"
                               placeholder=" " pattern="^[\w\'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&quot;&*(){}|~<>;:[\]]{1,99}$" required
                                title="Do not use special characters or numbers. Last name should have at least 2 letters.">
                        <label for="last_name">Last Name</label>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100" style="margin-top: 0px;">Update</button>
                </form>
                <button type="submit" class="btn btn-outline-danger btn-lg w-100" style="margin-top: 20px;"
                     data-bs-toggle="modal" data-bs-target="#confirmation_window">Delete account</button>
            </div>'.confirm_window("account", "scripts/delete_account.php", true);
    }

    function login(object $conn): string
    {
        $email = $conn->get_data("SELECT email FROM users WHERE user_id = ".$_SESSION['user_id'])[0]->email;
        return '<div class="text-dark bg-light" id="login_details_form">
                    <h2>Your login details</h2>
                    <form method="post" action="/TechTronic/scripts/update_email.php">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control form-control-lg form-control-plaintext" name="email" id="email" value="'.$email.'"
                                   placeholder=" " readonly>
                            <label for="email">Email</label>
                        </div>
                        <div class="collapse" id="email_form">
                            <div class="card card-body" style="padding: 0; border: none;">
                                <h5>Confirm with a password</h5>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control form-control-lg" name="confirm_password" 
                                        id="confirm_password" placeholder=" " required>
                                    <label for="confirm_password">Password</label>
                                </div>
                                <button type="submit" class="btn btn-lg btn-outline-success">Update</button>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-outline-secondary btn-lg w-100" style="margin-top: 0px;"
                         data-bs-toggle="collapse" href="#email_form" id="change_email">Change email</button>
                    <hr style="margin: 40px 0 40px 0">
                    
                    <form method="post" action="/TechTronic/scripts/update_password.php" id="password_form">
                        <div class="collapse" id="password_form_collapse">
                            <div class="card card-body" style="padding: 0; border: none;">
                                <h5>Change your password</h5>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control form-control-lg" name="password" 
                                        id="password" placeholder=" " required>
                                    <label for="password">Current password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control form-control-lg" name="new_password" 
                                        id="new_password" placeholder=" "  pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" required
                                        title="Password must include at least: one upper case English letter (A-Z), one lower case English letter (a-z), one number (0-9) and one special character (#?!@$%^&*-)">
                                    <label for="new_password">New password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control form-control-lg" name="confirm_password" 
                                        id="confirm_password2" placeholder=" " required>
                                    <label for="confirm_password2">Confirm new password</label>
                                    <div id="confirm_password2_message" class="invalid-feedback" style="font-size: 20px;">
                                        Passwords are not the same
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-lg btn-outline-success" id="submit_password_form">Update</button>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-outline-secondary btn-lg w-100" style="margin-top: 0px;" onclick="this.remove()"
                        data-bs-toggle="collapse" href="#password_form_collapse" id="change_password">Change password</button>
                </div>
                <script src="/TechTronic/scripts/JS/change_login_details.js"></script>'.confirm_window("account", "scripts/delete_account.php");
    }
