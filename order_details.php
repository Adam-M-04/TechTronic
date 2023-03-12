<?php
    session_start();
    if(!isset($_SESSION["user_id"])) {header("location: /TechTronic/cart.php"); exit();}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Order - TechTronic</title>
    <link rel="icon" type="image/png" href="/TechTronic/images/favicon.ico"/>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/order_details.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body class="min-vh-100 text-center text-white bg-dark">
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php"); ?>

    <h1>Select shipping and payment options</h1><br>

    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/order_details_content.php"); ?>

</body>
</html>