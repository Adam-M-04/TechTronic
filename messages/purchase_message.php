<?php
    session_start();
    if(!isset($_SESSION["user_id"])) {header("location: /shop/register.php");exit();}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
    <title>TechTronic</title>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/TechTronic/scripts/JS/open_payment_window.js"></script>
</head>
<body class="text-center text-white bg-dark">
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php"); ?>
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/purchase_message_content.php"); ?>
</body>
</html>