<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/forbidden.html");
    if(!isset($_POST['cv_id'])) {echo "ID no specified"; exit();}

    $id = intval($_POST['cv_id']);

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $images = $conn->get_data("SELECT image_path FROM product_images pi WHERE (SELECT COUNT(*) FROM product_images WHERE image_path = pi.image_path) <= 1 and cv_id = ".$id);
    foreach($images as $image)
    {
        if(file_exists('../images/product_images/'.$image->image_path)) unlink('../images/product_images/'.$image->image_path);
    }

    if($conn->query("DELETE FROM color_versions WHERE cv_id = ".$id))
    {
        if(isset($_POST['product_id'])) header("location: /TechTronic/admin/product_view/{$_POST['product_id']}/deleted/");
    }
    else
    {
        if(isset($_POST['product_id'])) header("location: /TechTronic/admin/product_view/{$_POST['product_id']}/error/");
    }
