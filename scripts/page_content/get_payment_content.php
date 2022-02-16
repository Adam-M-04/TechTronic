<?php

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $order_id = (int)$_GET['id'];
    $order_details = $conn->get_data("SELECT * FROM orders WHERE user_id = {$_SESSION['user_id']} AND order_id = ".$order_id);

    if($order_details == [])
    {
        echo "<br><h2>Order not found</h2>";
        exit();
    }

    $order_details = $order_details[0];
    if($order_details->is_paid)
    {
        echo "<br><h2>You already paid for this order</h2>";
        exit();
    }

    function payment_confirmation(string $value, int $order_id):string
    {
        $style = "style='text-align: left; font-size: 20px;'";
        return "<h1>Payment Details</h1>
            <p $style><strong>From: </strong> <span id='payer_name'></span></p>
            <p $style><strong>To: </strong> TechTronic</p>
            <p $style><strong>Amount: </strong><span class='text-primary'>$$value</span></p><br>
            <form action='/TechTronic/payment/process_payment.php' method='post'>
                <input type='hidden' name='id' value='$order_id'>
                <button type='submit' class='btn btn-lg btn-warning w-100'>Pay</button>
            </form>";
    }

    function card_form($value, $order_id)
    {
        $curr_year = date('Y');
        $script ="<script>
                        document.getElementById('login_button').onclick = ()=>{
                            let card_number_input = document.getElementById('number')
                            let holder_input = document.getElementById('holder')
                            let cvv_input = document.getElementById('cvv')
                            let year_input = document.getElementById('expiration')
                            const card_regex = new RegExp('^[0-9]{16}$');
                            const cvv_regex = new RegExp('^[0-9]{3,4}$');
                            if(!card_regex.test(card_number_input.value))
                            {
                                card_number_input.classList.add('is-invalid')
                                return
                            }
                            else card_number_input.classList.remove('is-invalid')
                            if(!(holder_input.value))
                            {
                                holder_input.classList.add('is-invalid')
                                return
                            }
                            else holder_input.classList.remove('is-invalid')
                            if(!cvv_regex.test(cvv_input.value))
                            {
                                cvv_input.classList.add('is-invalid')
                                return
                            }
                            else cvv_input.classList.remove('is-invalid')
                            if(parseInt(year_input.value) < $curr_year || year_input.value === '')
                            {
                                year_input.classList.add('is-invalid')
                                return
                            }
                            else year_input.classList.remove('is-invalid')
                                
                            document.getElementById('login_button').innerHTML = `<div class='spinner-border' role='status'><span class='visually-hidden'>Loading...</span></div>`
                            setTimeout(()=>{
                                let name = holder_input.value
                                document.getElementById('login_form').innerHTML = `".payment_confirmation($value, $order_id)."`
                                document.getElementById('payer_name').innerText = name
                            }, Math.random()*600+200)
                        }
                  </script>";

        return '<img src="/TechTronic/images/credit-card-icon2.svg" style="width: 40%; max-width: 300px;">
                <div style="margin: 20px;" id="login_form">
                    <h3>Fill in your details</h3>
                    <div class="form-floating mb-3 text-dark">
                      <input type="text" class="form-control" id="number" placeholder=" " autocomplete="off" maxlength="16">
                      <label for="number">Card Nummber</label>
                    </div>
                    <div class="form-floating text-dark">
                      <input type="text" class="form-control" id="holder" placeholder=" " autocomplete="off" maxlength="60">
                      <label for="holder">Holder Name</label>
                    </div>
                    <div class="d-flex justify-content-between" style="margin-top: 15px;">
                        <div style="width: 49%">
                            <div class="form-floating text-dark col-md-6">
                              <input type="text" class="form-control" id="cvv" placeholder=" " autocomplete="off" maxlength="4">
                              <label for="cvv">CVV</label>
                            </div>
                        </div>
                        <div style="width: 49%">
                            <div class="form-floating text-dark col-md-6">
                              <input type="number" min="'.$curr_year.'" max="3000" class="form-control" id="expiration" placeholder=" " autocomplete="off" maxlength="4">
                              <label for="expiration">Expiration Year</label>
                            </div>
                        </div>
                    </div>
                    
                    <br>
                    <button class="btn btn-lg btn-success w-100" id="login_button">Login</button>
                </div>'.$script;
    }

    function PayPal_form(string $value, int $order_id): string
    {
        $script ="<script>
                        document.getElementById('login_button').onclick = ()=>{
                            let email_input = document.getElementById('email')
                            let password_input = document.getElementById('password')
                            if(!(email_input.value))
                            {
                                email_input.classList.add('is-invalid')
                                return
                            }
                            else email_input.classList.remove('is-invalid')
                            if(!(password_input.value))
                            {
                                password_input.classList.add('is-invalid')
                                return
                            }
                            else password_input.classList.remove('is-invalid')
                                
                            document.getElementById('login_button').innerHTML = `<div class='spinner-border' role='status'><span class='visually-hidden'>Loading...</span></div>`
                            setTimeout(()=>{
                                let name = email_input.value
                                document.getElementById('login_form').innerHTML = `".payment_confirmation($value, $order_id)."`
                                document.getElementById('payer_name').innerText = name
                            }, Math.random()*600+200)
                        }
                  </script>";

        return '<img src="/TechTronic/images/paypal_logo.svg" style="width: calc(100% - 40px); margin: 20px;">
                <div style="margin: 20px;" id="login_form">
                    <h3>Login to PayPal</h3>
                    <div class="form-floating mb-3 text-dark">
                      <input type="text" class="form-control" id="email" placeholder=" " autocomplete="off">
                      <label for="email">Email or Mobile Number</label>
                    </div>
                    <div class="form-floating text-dark">
                      <input type="password" class="form-control" id="password" placeholder=" " autocomplete="off">
                      <label for="password">Password</label>
                    </div><br>
                    <button class="btn btn-lg btn-primary w-100" id="login_button">Login</button>
                </div>'.$script;
    }


echo match ((int)$order_details->payment_type) {
    1 => card_form($order_details->order_price, $order_id),
    2 => PayPal_form($order_details->order_price, $order_id),
    default => "An error occurred",
};
