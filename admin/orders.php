<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) {header("location: /TechTronic/admin"); exit();}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" href="/TechTronic/images/favicon.ico"/>
        <title>Orders - admin</title>
        <link rel="stylesheet" href="/TechTronic/styles/main.css">
        <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
        <link rel="stylesheet" href="/TechTronic/styles/admin-header.css">
        <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/admin-menu.php"); ?>

        <h1 class="display-1 text-center text-light">Orders</h1>

        <?php
            include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
            $conn = new Connection();
            include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_orders_filters.php");
            include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_orders_admin.php");
        ?>

    </body>
</html>