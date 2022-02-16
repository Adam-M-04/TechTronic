<?php
    session_start();
    if(isset($_SESSION["user_id"]))
    {
        $product_id = (int)$_REQUEST["cv_id"];
        $amount = (int)$_REQUEST["amount"];

        if($amount > 0)
        {
            include_once ("sql_connection.php");
            $conn = new Connection();

            $conn->obj->query("UPDATE cart SET amount = $amount WHERE user_id = {$_SESSION["user_id"]} AND cv_id = $product_id");
        }
    }
