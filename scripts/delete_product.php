<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/forbidden.html");
    if(!isset($_GET['id'])) exit();

    $id_to_delete = intval($_GET['id']);

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $color_versions = $conn->get_data("SELECT * FROM color_versions WHERE product_id = $id_to_delete");
    foreach ($color_versions as $color_version)
    {
        $images = $conn->get_data("SELECT image_path FROM product_images WHERE cv_id = ".$color_version->cv_id);
        foreach($images as $image)
        {
            if(file_exists('../images/product_images/'.$image->image_path)) unlink('../images/product_images/'.$image->image_path);
        }
        $conn->query("DELETE FROM color_versions WHERE cv_id = ".$color_version->cv_id);
    }

    if($conn->query("DELETE FROM products WHERE product_id = $id_to_delete"))
    {
        header("location: /TechTronic/admin/products/deleted/");
    }
    else header("location: /TechTronic/admin/products/failure/");
