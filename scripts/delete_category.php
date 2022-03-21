<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/forbidden.html");
    if(!isset($_GET['id'])) exit();

    $id_to_delete = intval($_GET['id']);

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    if($conn->query("DELETE FROM categories WHERE category_id = $id_to_delete"))
    {
        header("location: /TechTronic/admin/categories/d/success/");
    }
    else header("location: /TechTronic/admin/categories/d/failure/");
