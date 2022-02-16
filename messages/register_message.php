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
</head>
<body class="text-center text-white bg-dark">
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php"); ?>
    <?php if(isset($_GET["ok"])): ?>
        <h1 style="margin-top: 30px;">Registration successful!</h1>
        <h3>Welcome in TechTronic <?php echo ($_SESSION["user_name"] ?? ""); ?></h3>
    <?php endif; ?>
    <?php if(!isset($_GET["ok"])): ?>
        <h1 style="margin-top: 30px;">An error occurred</h1>
        <h2>Please try again later<h2>
    <?php endif; ?>
</body>
</html>