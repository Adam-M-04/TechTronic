<?php

    if(session_status() != PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["admin_id"])) {echo "Forbidden"; exit();} // Forbidden
    if(!isset($_POST["cv_id"])) {echo "No ID specified"; exit();} // No ID specified

    $id = intval($_POST['cv_id']);
    $error = false;

    // Image
    if(isset($_FILES['image'])){
        if($_FILES['image']["error"] == 0)
        {
            $image = $_FILES['image'];
            $extension = explode('.',$image['name']);
            $extension = strtolower(end($extension));
            if(in_array($extension, ['png', 'jpg', 'jpeg']))
            {
                if($image['size'] > 1048576) {
                    $error = "Max file size is 1MB";
                }
            }
            else
            {
                $error = "Wrong file extension";
            }
        }
        else
        {
            $error = "Image not selected";
        }
    }
    if($error)
    {
        echo $error;
        exit();
    }

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $max_id = $conn->get_data("SELECT image_id FROM product_images ORDER BY image_id DESC LIMIT 1")[0]->image_id + 1;

    $new_name = "{$id}_{$max_id}.".$extension;
    $new_path = "../images/product_images/".$new_name;
    if(move_uploaded_file($image['tmp_name'], $new_path))
    {
        $conn->query("INSERT INTO product_images (image_path, cv_id) VALUES ('$new_name', $id)");
    }
