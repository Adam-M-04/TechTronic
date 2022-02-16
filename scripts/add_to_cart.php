<?php
    session_start();
    if(isset($_SESSION["user_id"]))
    {
        $product_id = (int)$_REQUEST["cv_id"];
        $count = (int)($_REQUEST["count"] ?? 1);
        if($count < 1) $count = 1;

        include_once ("sql_connection.php");
        $conn = new Connection();

        $available = $conn->get_data("SELECT amount FROM color_versions WHERE cv_id = ".$product_id);

        if($available != [])
        {
            $amount = $available[0]->amount;

            if($amount > 0)
            {
                $product_in_cart = $conn->get_data("SELECT * FROM cart WHERE user_id = ".$_SESSION["user_id"]." AND cv_id = ".$product_id);
                if($product_in_cart != [])
                {
                    $product_in_cart = $product_in_cart[0];
                    if($amount > $product_in_cart->amount)
                    {
                        if($count + $product_in_cart->amount > $amount)
                        {
                            if($conn->query("UPDATE cart SET amount = {$amount} WHERE user_id = {$_SESSION["user_id"]} AND cv_id = {$product_id}"))
                                echo 1; # product added to cart
                        }
                        else
                        {
                            $new_amount = $count + $product_in_cart->amount;
                            if($conn->query("UPDATE cart SET amount = {$new_amount} WHERE user_id = {$_SESSION["user_id"]} AND cv_id = {$product_id}"))
                                echo 1; # product added to cart
                        }
                    }
                    else echo -2; # maximum amount of product reached
                }
                else
                {
                    $amount_to_add = $count <= $available[0]->amount ? $count : $available[0]->amount;
                    if($conn->query("INSERT INTO cart (user_id,cv_id,amount) VALUES ({$_SESSION["user_id"]},{$product_id},{$amount_to_add})"))
                        echo 1; # product added to cart
                }
            }
            else echo -1; # Product sold out
        }
        $conn->close();
    }
    else echo 0; # login first
