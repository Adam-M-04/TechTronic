<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/admin");
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
        <link rel="stylesheet" href="/TechTronic/styles/admin-products.css">
        <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body onload="filter_products(document.getElementById('search_input').value)">
        <?php
            include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/admin-menu.php");
            $msg = false; $color = '';
            if(isset($_GET['deleted']))
            {
                $msg = 'Product deleted successfully';
                $color = 'success';
            }
            if(isset($_GET['added']))
            {
                $msg = "Product added successfully <a href='/TechTronic/admin/product_view/{$_GET['added']}/' class='no-underline'>EDIT</a>";
                $color = 'success';
            }
            if(isset($_GET['failure']))
            {
                $msg = 'Am error occurred';
                $color = 'danger';
            }
            if($msg)
            {
                echo '<div class="container">
                        <div class="alert alert-'.$color.' alert-dismissible fade show" role="alert">
                          '.$msg.'
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      </div>';
            }
        ?>
        <h1 class="display-1 text-center text-light">Products</h1>
        <div class="container d-flex justify-content-center" style="margin-bottom: 50px;">
            <input type="text" class="form-control form-control-lg" style="max-width: 500px;" placeholder="Search..."
                oninput="filter_products(value)" id="search_input">
        </div>
        <div id="products">
            <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_products_admin.php"); ?>
        </div>

        <script src="/TechTronic/scripts/JS/filter_products_admin.js"></script>
    </body>
</html>