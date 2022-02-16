<?php
    session_start();
    if(!isset($_SESSION['user_id']) or !isset($_POST['control_val']))
    {
        header('location: /TechTronic/forbidden.html');
        exit();
    }

    $password = $_POST['confirm_password'] ?? '';

    include_once ("sql_connection.php");
    $conn = new Connection();

    try {
        $password_hash = $conn->get_data("SELECT password_hash FROM users WHERE user_id = ".$_SESSION['user_id'])[0]->password_hash;
    }
    catch (Exception $e)
    {
        $password_hash = '';
    }

    if(password_verify($password, $password_hash))
    {
        $response = $conn->query('DELETE FROM users WHERE user_id = '.$_SESSION['user_id']);
        if($response)
        {
            session_unset();
            session_destroy();
            header('location: /TechTronic/messages/delete_message.php');
        }
        else
        {
            header('location: /TechTronic/settings.php?c=details&failure');
        }
    }
    else
    {
        header('location: /TechTronic/settings.php?c=details&failure=2');
    }