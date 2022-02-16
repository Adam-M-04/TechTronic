<?php
    session_start();
    if(!isset($_SESSION["user_id"]) or !isset($_POST['control_val']))
    {
        header("location: /TechTronic/forbidden.html");
        exit();
    }
    include_once ($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();
    $address_id = $conn->get_data("SELECT address_id FROM users WHERE user_id = {$_SESSION['user_id']}")[0]->address_id;
    if($address_id != null)
    {
        $conn->obj->begin_transaction();
        $conn->obj->autocommit(false);
        if($conn->query("UPDATE users SET address_id = null WHERE user_id = {$_SESSION["user_id"]}")
            and $conn->query("DELETE FROM address WHERE address_id = $address_id"))
        {
            $conn->obj->commit();
            header("location: /TechTronic/settings/address/success=d");
            $conn->close();
            exit();
        }
        else
        {
            $conn->obj->rollback();
            header("location: /TechTronic/settings/address/failure");
            $conn->close();
            exit();
        }
    }
    header("location: /TechTronic/settings/address/failure=3");

    $conn->close();
