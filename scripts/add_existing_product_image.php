<?php
    if(session_status() != PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["admin_id"])) {echo "Forbidden"; exit();} // Forbidden
    if(!isset($_POST["cv_id"]) or !isset($_POST["filename"])) {echo "No ID specified"; exit();} // No ID specified

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $cv_id = intval($_POST["cv_id"]);
    $filename = $_POST["filename"];

    if(!$conn->query("INSERT INTO product_images (image_path, cv_id) VALUES ('$filename', $cv_id)")) echo "Could not upload";
