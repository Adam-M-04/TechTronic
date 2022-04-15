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
        <title>Admin dashboard</title>
        <link rel="stylesheet" href="/TechTronic/styles/main.css">
        <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
        <link rel="stylesheet" href="/TechTronic/styles/dashboard.css">
        <link rel="stylesheet" href="/TechTronic/styles/admin-header.css">
        <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/admin-menu.php"); ?>
        <h1 class="display-1 text-center text-light">Welcome, Admin!</h1>

        <div class="container">
            <a href="/TechTronic/admin/products/" class="col-5 no-underline">
                <div class=" bg-light text-dark link-cell d-flex align-items-center justify-content-center">Products</div>
            </a>
            <a href="/TechTronic/admin/categories/" class="col-5 no-underline">
                <div class="bg-light text-dark link-cell d-flex align-items-center justify-content-center">Categories</div>
            </a>
            <a href="/TechTronic/admin/orders/" class="col-5 no-underline">
                <div class="bg-light text-dark link-cell d-flex align-items-center justify-content-center">Orders</div>
            </a>
        </div>

    </body>
</html>