<?php
    if(session_status() != PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["admin_id"])) exit();

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $images_HTML = "<div class='row row-cols-auto w-100' style='margin-left: 10px;'>";
    $images_HTML .= "<div class='col image-cell'><label id='upload_image_label'>
                <img src='/TechTronic/images/plus-square.svg' class='img-thumbnail gallery-image add-image-icon-gallery'
                    title='Upload' data-bs-toggle='tooltip'>
            </label></div>";
    foreach ($conn->get_data("SELECT image_path, CONCAT(product_name_base, ' ', product_name_version) as p_name, color_name
        FROM product_images LEFT JOIN color_versions USING (cv_id) LEFT JOIN products USING (product_id) LEFT JOIN colors USING (color_id) 
        GROUP BY image_path ORDER BY image_id DESC") as $image)
    {
        $images_HTML .= "<div class='col image-cell'>
                <img src='/TechTronic/images/product_images/{$image->image_path}' class='img-thumbnail gallery-image'
                    onclick='add_existing_product_image(`{$image->image_path}`)' 
                    title='{$image->p_name} ({$image->color_name})' data-bs-toggle='tooltip'>
            </div>";
    }
    $images_HTML .= "</div";

    echo '<div class="modal fade" id="images_from_gallery" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">';

    echo '<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-uppercase">Select image from gallery or upload new</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">'.$images_HTML.'</div>
    </div>';

    echo '</div></div>';
