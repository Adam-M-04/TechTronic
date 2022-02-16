<?php
    session_start();
    if(!isset($_SESSION["user_id"])) header("location: /TechTronic/register.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Orders - TechTronic</title>
    <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <link rel="stylesheet" href="/TechTronic/styles/user_orders.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/TechTronic/scripts/JS/open_payment_window.js"></script>
</head>
<body class="min-vh-100 text-center text-white bg-dark">
<?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php"); ?>

<?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_user_orders.php"); ?>


<script src="/TechTronic/scripts/JS/add_to_cart.js"></script>

</body>
</html>