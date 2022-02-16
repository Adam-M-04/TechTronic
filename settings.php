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
    <title>Settings - TechTronic</title>
    <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/settings.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="min-vh-100 text-center text-white bg-dark">
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php");?>

    <div id="message" class="d-flex justify-content-center"></div>

    <div class="btn-group">
        <a href="/TechTronic/settings/details/" class="btn btn-lg btn-primary btn-navigation" aria-current="page">Account details</a>
        <a href="/TechTronic/settings/address/" class="btn btn-lg btn-primary btn-navigation">Address</a>
        <a href="/TechTronic/settings/login/" class="btn btn-lg btn-primary btn-navigation">Login information</a>
    </div>

    <div id="content">
        <?php include_once("./scripts/page_content/settings_content.php"); ?>
    </div>

</body>
</html>