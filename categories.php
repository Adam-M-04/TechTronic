<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
    <title>Categories - TechTronic</title>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/categories.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="min-vh-100 text-center text-white bg-dark">
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php"); ?>

    <h1>Categories</h1>

    <div id="content" class="d-flex justify-content-center flex-wrap">
        <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_categories.php"); ?>
    </div>

</body>
</html>