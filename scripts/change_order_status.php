<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) {echo 0; exit();}
    if(!(isset($_POST['order_id']) and isset($_POST['status_id']))) {
        echo 0;
        exit();
    }

    $order_id = intval($_POST['order_id']);
    $status_id = intval($_POST['status_id']);

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    if(!$conn->query("UPDATE orders SET order_status = $status_id WHERE order_id = $order_id")) echo 0;
