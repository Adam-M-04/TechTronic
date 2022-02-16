<?php

    # Function closes connection and go back to address form with error code
    function go_back(string $err_code, object $conn, bool $rollback = true): void
    {
        if($rollback) $conn->obj->rollback();
        header("location: /TechTronic/settings/address/failure=$err_code");
        $conn->close();
        exit();
    }

    session_start();
    if(!isset($_SESSION['user_id'])){header("location: /TechTronic/forbidden.html");exit();}
    include_once ("sql_connection.php");
    $conn = new Connection();

    $phone = htmlentities(
        preg_match('/^\d{3}-\d{3}-\d{4}$/',$_POST["phone"])?$_POST["phone"]:"");
    $street = htmlentities(
        preg_match('/^.{1,100}$/',$_POST["street"])?$_POST["street"]:"");
    $city = htmlentities(
        preg_match('/^([a-zA-Z\x{0080}-\x{024F}]+(?:. |-| |\'))*[a-zA-Z\x{0080}-\x{024F}]*$/u',$_POST["city"])?$_POST["city"]:"");
    $zip_code = htmlentities(
        preg_match('/^\d{5}$/',$_POST["zip_code"])?$_POST["zip_code"]:"");

    $state_id = false;
    $state_name = htmlentities($_POST['state']);
    $state_query = $conn->obj->prepare('SELECT state_id FROM us_states WHERE state_name = ?');
    $state_query->bind_param('s', $state_name);
    $state_query->execute();
    $state_id = $state_query->get_result()->fetch_object();
    $state_query->close();

    if(strlen($phone) == 0 or strlen($street) == 0 or strlen($city) == 0 or strlen($zip_code) == 0 or $state_id == false)
        go_back(1, $conn, false);


    $address_id = $conn->get_data("SELECT address_id FROM users WHERE user_id = {$_SESSION['user_id']}")[0]->address_id;

    $conn->obj->begin_transaction();
    $conn->obj->autocommit(false);

    if($address_id == null)
    {
        $address_query = $conn->obj->prepare('INSERT INTO address (state_id, city, zip, street, phone_number) VALUES (?,?,?,?,?)');
        if(!$address_query) go_back(0, $conn, true);
        $address_query->bind_param('issss', $state_id->state_id, $city, $zip_code, $street, $phone);
        $response = $address_query->execute();
        if(!$response) go_back(0, $conn);

        $set_address_result = $conn->obj->query("UPDATE users SET address_id = {$address_query->insert_id} 
        WHERE user_id = {$_SESSION['user_id']}");
        if(!$set_address_result) go_back(0, $conn);
    }
    else
    {
        $address_query = $conn->obj->prepare('UPDATE address SET state_id=?, city=?, zip=?, street=?, phone_number=? 
            WHERE address_id = '.$address_id);
        if(!$address_query) go_back(0, $conn, true);
        $address_query->bind_param('issss', $state_id->state_id, $city, $zip_code, $street, $phone);
        $response = $address_query->execute();
        if(!$response) go_back(0, $conn);
    }

    if($response) $conn->obj->commit();
    else go_back(0, $conn);

    $address_query->close();
    $conn->close();
    header("location: /TechTronic/settings/address/success");
