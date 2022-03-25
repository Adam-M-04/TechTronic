<?php
    if(session_status() != PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["admin_id"])) exit();
    if(!isset($_POST["product_id"])) {echo "no ID specified";}

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $product_id = intval($_POST['product_id']);
    $s_name = htmlentities($_POST['specification_name']);
    $s_value = htmlentities($_POST['specification_value']);

    if($s_name == "" or $s_value == "")
    {
        echo -1;
        exit();
    }

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/get_feature_name_id.php");
    $s_name = get_feature_name_ID($s_name, $conn);
    $s_value = get_feature_value_ID($s_value, $conn);

    if(!$conn->query("INSERT INTO product_specification (product_id, sn_id, sv_id) VALUES ($product_id, $s_name, $s_value)"))
    {
        echo -1;
    }