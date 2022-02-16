<?php session_start();?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart - TechTronic</title>
    <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/cart.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/TechTronic/scripts/JS/cart.js"></script>
</head>
<body class="min-vh-100 text-center text-white bg-dark">
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php"); ?>

    <h1 id="cart_title">Your Shopping Cart</h1><br>

    <?php if(!isset($_SESSION["user_id"])): ?>
        <br><h3>Please sign in to see the products in the cart</h3>
    <?php endif; ?>
    <?php if(isset($_SESSION["user_id"])): ?>
        <div id="content" class="align-items-stretch d-flex justify-content-center flex-wrap">
            <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_cart_products.php"); ?>
        </div>
    <?php endif; ?>

</body>
</html>