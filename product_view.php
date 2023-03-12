<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TechTronic</title>
    <link rel="icon" type="image/png" href="/TechTronic/images/favicon.ico"/>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/product_view.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="min-vh-100 text-center text-white bg-dark">
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php"); ?>
    <div id="content" class="d-flex justify-content-center flex-wrap">
        <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_product_details.php"); ?>
    </div>

    <script src="/TechTronic/scripts/JS/add_to_cart.js"></script>
    <script>
        let tmp = null
        for(let tooltip of document.querySelectorAll('[data-bs-toggle="tooltip"]')) tmp = new bootstrap.Tooltip(tooltip)
    </script>
</body>
</html>