<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/forbidden.html");
    if(!isset($_POST['id'])) {echo "ID no specified"; exit();}

    if(!(isset($_POST["color"]) and isset($_POST["amount"]) and isset($_POST["price"])))
    {
        header("location: /TechTronic/admin/product_view/{$_POST['id']}/error/");
        exit();
    }

    if(!($_POST["color"] and $_POST["amount"] >= 0 and $_POST["price"]))
    {
        header("location: /TechTronic/admin/product_view/{$_POST['id']}/error/");
        exit();
    }

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/get_feature_name_ID.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $id = intval($_POST['id']);
    $color = get_color_ID(htmlentities($_POST["color"]), $conn);
    $amount = intval($_POST["amount"]);
    $price = floatval($_POST["price"]);

    if($conn->query("INSERT INTO color_versions (product_id, color_id, price, amount) 
        VALUES ($id, $color, $price, $amount)"))
    {
        header("location: /TechTronic/admin/product_view/{$id}/added/");
    }
    else
    {
        header("location: /TechTronic/admin/product_view/{$id}/error/");
    }
