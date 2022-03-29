<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/forbidden.html");
    if(!isset($_POST['cv_id'])) {echo "ID no specified"; exit();}

    $cv_id = intval($_POST['cv_id']);

    if(!(isset($_POST["color"]) and isset($_POST["amount"]) and isset($_POST["price"]) and isset($_POST["discount_price"])))
    {
        header("location: /TechTronic/admin/product_view/{$_POST['product_id']}/error/");
        exit();
    }

    if(!($_POST["color"] and $_POST["amount"] >= 0 and $_POST["price"] > 0 and ($_POST['discount_price']) == '' ? 1 : $_POST['discount_price']) > 0
        and $_POST['price'] > ($_POST['discount_price']) == '' ? 0 : $_POST['discount_price'])
    {
        header("location: /TechTronic/admin/product_view/{$_POST['id']}/error/");
        exit();
    }

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/get_feature_name_ID.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $color_id = get_color_ID(htmlentities($_POST['color']), $conn);
    $amount = intval($_POST['amount']);
    $price = floatval($_POST['price']);
    $discount_price = $_POST["discount_price"] ? floatval($_POST["discount_price"]) : "NULL";

    if($conn->query("UPDATE color_versions SET color_id = $color_id, amount = $amount, price = $price, 
                          discount_price = $discount_price WHERE cv_id = ".$cv_id))
    {
        if(isset($_POST['product_id'])) header("location: /TechTronic/admin/product_view/{$_POST['product_id']}/edited/");
    }
    else
    {
        if(isset($_POST['product_id'])) header("location: /TechTronic/admin/product_view/{$_POST['product_id']}/error/");
    }
