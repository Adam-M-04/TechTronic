<?php
    session_start();
    if(isset($_SESSION["user_id"])) header("location: /TechTronic/");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
    <title>Register account - TechTronic</title>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/register_panel.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="text-center text-white bg-dark">

    <?php
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php");
        if(isset($_GET["e"])) echo "<div class='warning' onclick='this.remove()'>
            <div class=\"alert alert-danger\" role=\"alert\" style='width: 331px;'>The entered data is invalid</div></div>"
    ?>

    <div id="content">
        <form id="form" class="bg-light text-dark" method="post" action="/TechTronic/scripts/register_account.php">
            <h1 class="mb-3" id="header">Create account</h1>
            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-lg" name="first_name" id="first_name"
                       placeholder=" " pattern="^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&quot;&*(){}|~<>;:[\]]{1,99}$" required
                       title="Do not use special characters or numbers. First name should have at least 2 letters.">
                <label for="first_name">First Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-lg" name="last_name" id="last_name"
                       placeholder=" " pattern="^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&quot;&*(){}|~<>;:[\]]{1,99}$" required
                       title="Do not use special characters or numbers. Last name should have at least 2 letters.">
                <label for="last_name">Last Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder=" " maxlength="320" required>
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control form-control-lg" name="password_1" id="password_1"
                       placeholder=" " pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" required
                title="Password must include at least: one upper case English letter (A-Z), one lower case English letter (a-z),
                one number (0-9) and one special character (#?!@$%^&*-)">
                <label for="password_1">Password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control form-control-lg" name="password_2" id="password_2" placeholder=" " required>
                <label for="password_2">Confirm Password</label>
                <div class="invalid-feedback">
                    Passwords do not match
                </div>
            </div>
            <input type="submit" class="btn btn-success btn-lg" value="Create account" id="submit_button">
            <div id="policy">
                By creating an account, you agree to <br>TechTronic's Privacy policy.
            </div>
        </form>


    <!-- Popup -->
        <div class="modal fade" id="email_alert" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-dark popup-header">An account with this email address already exists</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center flex-nowrap">
                        <p class="text-dark">If this email belongs to you, please log in.</p>
                        <button type="button" class="btn btn-success" onclick="email_popup.hide();login_window.show()">Login</button>
                    </div>
                </div>
        </div>
    </div>

    </div>

    <script src="scripts/JS/registration.js"></script>
    <script>const login_window = new bootstrap.Modal(document.getElementById("login_window"))</script>

</body>
</html>