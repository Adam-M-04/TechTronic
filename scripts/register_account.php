<?php
    session_start();

    $first_name = htmlentities(
        preg_match('/^[\w\'\-,.][^0-9_!¡?÷?¿\/\\+=@#$%ˆ"&*(){}|~<>;:[\]]{1,99}$/',$_POST["first_name"])?$_POST["first_name"]:"");
    $last_name = htmlentities(
        preg_match('/^[\w\'\-,.][^0-9_!¡?÷?¿\/\\+=@#$%ˆ"&*(){}|~<>;:[\]]{1,99}$/',$_POST["last_name"])?$_POST["last_name"]:"");
    $email = htmlentities(
        filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)?$_POST["email"]:"");
    $password1 = htmlentities(
        preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $_POST["password_1"])?$_POST["password_1"]:"");
    $password2 = htmlentities($_POST["password_2"]);

    if($password1 != $password2 or strlen($first_name) == 0 or strlen($last_name) == 0 or strlen($email) == 0 or strlen($password1) == 0)
    {
        header("Location: /TechTronic/register.php?e");
        exit();
    }

    $password_hash = password_hash($password1, PASSWORD_DEFAULT, ['cost' => 12]);

    include_once ("sql_connection.php");
    $conn = new Connection();

    $query = $conn->obj->prepare('INSERT INTO users (email, password_hash, first_name, last_name) 
        VALUES (?,?,?,?)');
    if(!$query) {header("Location: /TechTronic/messages/register_message.php");exit();}

    $query->bind_param('ssss', $email, $password_hash,$first_name,$last_name);

    $response = $query->execute();
    if(!$response) {header("Location: /TechTronic/messages/register_message.php");exit();}

    #starting user session (logging in)
    $_SESSION["user_id"] = $query->insert_id;
    $_SESSION["user_name"] = $first_name." ".$last_name;

    $query->close();
    $conn->close();

    header("Location: /TechTronic/messages/register_message.php".($response == 1 ? "?ok" : ""));

