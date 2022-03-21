<?php
    session_start();
    if(session_status() != PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["admin_id"])) {echo "Forbidden"; exit();}
    if(!isset($_POST["filename"])) {echo "No image specified"; exit();}

    if(file_exists("../images/product_images/".$_POST["filename"]))
    {
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
        $conn = new Connection();
        if($conn->query("DELETE FROM product_images WHERE image_path = '{$_POST["filename"]}'"))
        {
            if(unlink("../images/product_images/".$_POST["filename"]))
            {
                exit();
            }
        }
    }
    echo -1;