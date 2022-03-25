<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/admin");

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
    <title>Products - admin</title>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <link rel="stylesheet" href="/TechTronic/styles/admin-header.css">
    <link rel="stylesheet" href="/TechTronic/styles/admin-product_view.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/TechTronic/scripts/JS/product_images.js"></script>
    <script src="/TechTronic/scripts/JS/product_view_specification.js"></script>
</head>
<body>
    <?php
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/admin-menu.php");
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/admin_product_messages.php");
    ?>

    <h2 class="display-2 text-center text-light">
        <?php
        if(!isset($_GET['id']))
        {
            echo "No ID specified";
            exit();
        }

        if($_GET['id'] == "0")
        {
            echo "Add new product";
            $product = false;
        }
        else
        {
            $query = "SELECT *, 
                        (SELECT specification_name FROM specification_names WHERE sn_id = feature_1_name) as feature_1,
                        (SELECT specification_name FROM specification_names WHERE sn_id = feature_2_name) as feature_2,
                        (SELECT specification_name FROM specification_names WHERE sn_id = feature_3_name) as feature_3,
                        (SELECT specification_value FROM specification_values WHERE sv_id = products.feature_1_val) as feature_val_1,
                        (SELECT specification_value FROM specification_values WHERE sv_id = products.feature_2_val) as feature_val_2,
                        (SELECT specification_value FROM specification_values WHERE sv_id = products.feature_3_val) as feature_val_3 
                        FROM products JOIN categories USING (category_id) JOIN producers USING (producer_id)
                        WHERE product_id = ".(intval($_GET['id']));
            $product = $conn->get_data($query);

            if($product)
            {
                $product = $product[0];
                echo "Edit product - $product->product_name_base $product->product_name_version";
            }
            else
            {
                echo "Product not found";
                exit();
            }
        }

        $categories = $conn->get_data("SELECT * FROM categories");
        $categories_HTML = "<select class='form-select form-select-lg' id='category_input' name='category_id'>";
        foreach ($categories as $category)
        {
            $categories_HTML .= "<option value='{$category->category_id}' ";
            if($product) $categories_HTML .=  $category->category_id == $product->category_id ? " selected" : "";
            $categories_HTML .= ">{$category->category_name}</option>";
        }
        $categories_HTML .= "</select>";

        $producers = $conn->get_data("SELECT producer_name FROM producers");
        $producers_datalist = "<datalist id='producers_datalist'>";
        foreach ($producers as $producer) {$producers_datalist .= "<option value='{$producer->producer_name}'</option>";}
        $producers_datalist .= "</datalist>";

        $feature_names = $conn->get_data("SELECT specification_name FROM specification_names");
        $features_names_datalist = "<datalist id='features_names_datalist'>";
        foreach ($feature_names as $fv) {$features_names_datalist .= "<option value='{$fv->specification_name}'</option>";}
        $features_names_datalist .= "</datalist>";

        $feature_values = $conn->get_data("SELECT specification_value FROM specification_values");
        $features_datalist = "<datalist id='features_datalist'>";
        foreach ($feature_values as $fv) {$features_datalist .= "<option value='{$fv->specification_value}'</option>";}
        $features_datalist .= "</datalist>";

        # PRODUCT DETAILS
    ?>
    </h2>
    <form method="post" action="/TechTronic/scripts/add_product.php" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo intval($_GET['id'])?>" name="id">
        <div class="container bg-white form-container">
            <div class="row">
                <div class="col col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control form-control-lg" id="floating_name" placeholder=" " maxlength="150"
                            value="<?php if($product) echo $product->product_name_base; ?>" name="product_name_base" required>
                        <label for="floating_name">Product name</label>
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control form-control-lg" id="floating_version" placeholder=" " maxlength="150"
                               value="<?php if($product) echo $product->product_name_version; ?>" name="product_name_version">
                        <label for="floating_version">Product version</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-md-6">
                    <label for="producer_input" class="form-label">Producer</label>
                    <input type="text" class="form-control form-control-lg" maxlength="100" list="producers_datalist"
                           value="<?php if($product) echo $product->producer_name; ?>" id="producer_input" name="producer" required>
                    <?php echo $producers_datalist; ?>
                </div>
                <div class="col col-md-6">
                    <label for="category_input" class="form-label">Category</label>
                    <?php echo $categories_HTML; ?>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-end">
                    <label class="form-label"><?php echo "Feature 1".($product?" ($product->feature_1)" : ""); ?></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control form-control-lg" value="<?php if($product) echo $product->feature_val_1; ?>"
                           list="features_datalist" name="feature_1_val" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-end">
                    <label class="form-label"><?php echo "Feature 2".($product?" ($product->feature_2)" : ""); ?></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control form-control-lg" value="<?php if($product) echo $product->feature_val_2; ?>"
                           list="features_datalist" name="feature_2_val" required>
                </div>
            </div><div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-end">
                    <label class="form-label"><?php echo "Feature 3".($product?" ($product->feature_3)" : ""); ?></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control form-control-lg" value="<?php if($product) echo $product->feature_val_3; ?>"
                           list="features_datalist" name="feature_3_val" required>
                </div>
            </div>
            <?php echo $features_datalist.$features_names_datalist; ?>
            <div class="row">
                <div class="col-md-3 d-flex align-items-center justify-content-end">
                    <label class="form-label">Warranty (months)</label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control form-control-lg" value="<?php if($product) echo $product->warranty; ?>"
                        max="120" min="0" step="1" name="warranty" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><button class="btn btn-lg btn-outline-success w-100">Submit</button></div>
            </div>
        </div>
    </form>

    <?php
        if($_GET['id'] > 0)
        echo '<br><br>
                <h2 class="display-2 text-center text-light">Specification</h2>
                <div class="container specification-container" id="specification">
                    <script>
                        const product_id = '.$_GET['id'].';
                        load_specification()
                    </script>
                </div>';
    ?>;


    <?php
        # COLOR VERSIONS
        if($_GET['id'] > 0)
        {
            echo "<br><br><h2 class='display-2 text-light text-center'>Color versions</h2>";
            $color_versions = $conn->get_data("SELECT * FROM color_versions JOIN colors USING (color_id) WHERE product_id = ".$_GET['id']);
            $index = 0;
            foreach ($color_versions as $color_version)
            {
                echo "<div class='container bg-white color-version-container'>
                        <div class='row d-flex justify-content-center images-row'>
                            <script>load_product_images({$index}, $color_version->cv_id)</script>
                        </div>
                        <form class='w-100' method='post' action='/TechTronic/scripts/edit_color_version.php' id='edit_form_{$color_version->cv_id}'>
                        <input type='hidden' name='cv_id' value='{$color_version->cv_id}'>
                        <input type='hidden' name='product_id' value='{$color_version->product_id}'>
                        <div class='row'>
                            <div class='col-4'>
                                <label class='form-label h3'>Color</label>
                                <input type='text' class='form-control form-control-lg' value='{$color_version->color_name}'
                                    list='colors_datalist' name='color'>
                            </div>
                            <div class='col-4'>
                                <label class='form-label h3'>Amount</label>
                                <input type='number' class='form-control form-control-lg' min='0' max='99999' step='1' 
                                    value='{$color_version->amount}' name='amount'>
                            </div>
                            <div class='col-4'>
                                <label class='form-label h3'>Price <strong class='text-primary'>$</strong></label>
                                <input type='number' class='form-control form-control-lg' min='0.01' step='0.01' 
                                    value='{$color_version->price}' name='price' onchange='this.value = parseFloat(this.value).toFixed(2);'>
                            </div>
                        </div>
                        </form>
                        <div class='row buttons-row'>
                            <div class='col-6'>                                   
                                <button class='btn btn-lg btn-outline-success w-100' 
                                    onclick='document.getElementById(`edit_form_{$color_version->cv_id}`).submit()'>Edit</button>
                            </div>
                            <div class='col-6'>
                                <input type='hidden' name='cv_id' value='{$color_version->cv_id}'>
                                <input type='hidden' name='product_id' value='{$color_version->product_id}'>
                                <button class='btn btn-lg btn-outline-danger w-100' data-bs-target='#confirm_delete' data-bs-toggle='modal' 
                                        onclick='delete_product_click(`{$color_version->cv_id}`, {$color_version->product_id})'>
                                    Delete
                                </button>
                            </div>
                        </div>
                      </div>";
                ++$index;
            }

            // Add new
            echo "<form method='post' action='/TechTronic/scripts/add_color_version.php'>
                  <input type='hidden' name='id' value='{$_GET['id']}'>
                  <div class='container bg-white color-version-container'>
                    <div class='row'>
                        <div class='col-4'>
                            <label class='form-label h3'>Color</label>
                            <input type='text' class='form-control form-control-lg' list='colors_datalist' name='color' required>
                        </div>
                        <div class='col-4'>
                            <label class='form-label h3'>Amount</label>
                            <input type='number' class='form-control form-control-lg' min='0' max='99999' step='1' name='amount' required>
                        </div>
                        <div class='col-4'>
                            <label class='form-label h3'>Price <strong class='text-primary'>$</strong></label>
                            <input type='number' class='form-control form-control-lg' min='0.01' step='0.01' name='price' required
                                onchange='this.value = parseFloat(this.value).toFixed(2);'>
                        </div>
                        </div>
                        <div class='row buttons-row'>
                            <div class='col-12'>
                                <button class='btn btn-lg btn-success w-100' type='submit'>Add</button>
                            </div>
                        </div>
                  </div></form>";

            # Colors datalist
            $all_colors = $conn->get_data("SELECT color_name FROM colors");
            echo "<datalist id='colors_datalist'>";
            foreach ($all_colors as $color)
            {
                echo "<option value='{$color->color_name}'>";
            }
            echo "</datalist>";

            echo '<div class="modal fade" id="confirm_delete" tabindex="-1" aria-labelledby="confirm_delete" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Are you sure you want to delete color version?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form method="post" action="/TechTronic/scripts/delete_color_version.php">
                          <div class="modal-body d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary btn-lg w-50" data-bs-dismiss="modal" style="margin: 5px 5px 5px -5px;">Cancel</button>
                            <button type="submit" class="btn btn-danger btn-lg w-100" style="margin: 5px;">Delete</button>
                            <input type="hidden" id="cv_id_input" name="cv_id" value="-1">
                            <input type="hidden" id="product_id_input" name="product_id" value="-1">
                          </div>
                       </form>
                    </div>
                  </div>
              </div>
              
            <script>
                function delete_product_click(cv_id, product_id)
                {
                    document.getElementById("cv_id_input").value = cv_id
                    document.getElementById("product_id_input").value = product_id
                }
                
                get_images_gallery()
            </script>
            ';
        }

    ?>

    <div id="gallery_modal_container"></div>

    <?php $conn->close(); ?>
    </body>
</html>