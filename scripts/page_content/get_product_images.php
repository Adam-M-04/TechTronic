<?php
    if(session_status() != PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["admin_id"])) {echo "Forbidden"; exit();} // Forbidden
    if(!isset($_GET["cv_id"]) or !isset($_GET['index'])) {echo "No ID specified"; exit();} // No ID specified

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $main_image = $conn->get_data("SELECT main_image_id FROM color_versions WHERE cv_id = ".$_GET['cv_id']);
    $main_image_id = count($main_image) ? $main_image[0]->main_image_id : null;

    $images = $conn->get_data("SELECT image_path, image_id FROM product_images WHERE cv_id = ".$_GET['cv_id']);
    $images_HTML = "";
    foreach ($images as $image)
    {
        $main_image = "";
        if($main_image_id == $image->image_id) $main_image = "main_product_image border";

        $images_HTML .= "<div class='product-image-container d-flex justify-content-center align-items-center $main_image' 
                            ondblclick='select_main_image({$_GET['index']},{$_GET['cv_id']},{$image->image_id})'
                            data-bs-toggle='tooltip' data-bs-placement='bottom' title='Double click to select as main image'>
                <img src='/TechTronic/images/product_images/{$image->image_path}' class='product-image'>
                <button class='btn btn-danger delete-button' onclick='delete_image({$_GET['index']},{$_GET['cv_id']}, 
                `{$image->image_path}`)'>Delete</button>
            </div>";
    }
    if(count($images) < 6) $images_HTML .=
        "<label for='image_input_{$_GET['cv_id']}' class='add_button_label d-flex align-items-center justify-content-center'>
            <img src='/TechTronic/images/plus-square.svg' class='add-image-icon'>
         </label>
         <input type='file' style='display: none;' id='image_input_{$_GET['cv_id']}' 
            onchange='add_product_image({$_GET['index']},{$_GET['cv_id']})'>";

    echo $images_HTML;