<?php
    if(session_status() != PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["admin_id"])) exit();
    if(!isset($_GET["id"])) {echo "no ID specified";}

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $id = intval($_GET['id']);

    if(!$conn->query("DELETE FROM product_specification WHERE id = $id"))
    {
        echo -1;
    }