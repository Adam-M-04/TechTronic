<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/forbidden.html");
    if(!isset($_POST['cv_id'])) {echo "ID no specified"; exit();}
    if(!isset($_POST['image_id'])) {echo "ID no specified"; exit();}

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $cv_id = intval($_POST['cv_id']);
    $image_id = intval($_POST['image_id']);

    if(!$conn->query("UPDATE color_versions SET main_image_id = $image_id WHERE cv_id = $cv_id"))
    {
        echo -1;
    }
