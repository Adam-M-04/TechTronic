<?php
    session_start();
    if(isset($_SESSION["user_id"]))
    {
        $product_id = (int)$_REQUEST["cv_id"];

        include_once ("sql_connection.php");
        $conn = new Connection();

        $conn->obj->query("DELETE FROM cart WHERE user_id = {$_SESSION["user_id"]} AND cv_id = $product_id");

        $conn->close();
    }
