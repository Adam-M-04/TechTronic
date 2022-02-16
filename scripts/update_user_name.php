<?php

    function go_back(string $err_code, object $conn, bool $rollback = true): void
    {
        if($rollback) $conn->obj->rollback();
        header("location: /TechTronic/settings/details/failure=$err_code");
        $conn->close();
        exit();
    }

    session_start();
    if(!isset($_SESSION['user_id'])){header("location: /TechTronic/forbidden.html");exit();}
    include_once ("sql_connection.php");
    $conn = new Connection();

    $first_name = htmlentities(
        preg_match('/^[\w\'\-,.][^0-9_!¡?÷?¿\/\\+=@#$%ˆ"&*(){}|~<>;:[\]]{1,99}$/',$_POST["first_name"])?$_POST["first_name"]:"");
    $last_name = htmlentities(
        preg_match('/^[\w\'\-,.][^0-9_!¡?÷?¿\/\\+=@#$%ˆ"&*(){}|~<>;:[\]]{1,99}$/',$_POST["last_name"])?$_POST["last_name"]:"");

    if(strlen($first_name) == 0 or strlen($last_name) == 0) go_back(1, $conn, false);

    $conn->obj->begin_transaction();
    $conn->obj->autocommit(false);

    $update_query = $conn->obj->prepare('UPDATE users SET first_name = ?, last_name = ? WHERE user_id = '.$_SESSION['user_id']);
    if(!$update_query) go_back(0, $conn, true);
    $update_query->bind_param('ss', $first_name, $last_name);
    $response = $update_query->execute();

    if($response) $conn->obj->commit();
    else go_back(0, $conn);

    $_SESSION['user_name'] = $first_name." ".$last_name;
    $update_query->close();
    $conn->close();
    header("location: /TechTronic/settings/details/success");
