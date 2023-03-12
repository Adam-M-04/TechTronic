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
        <link rel="stylesheet" href="/TechTronic/styles/order-view-admin.css">
        <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>

    <?php
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/admin-menu.php");
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
        $conn = new Connection();
        if(!isset($_GET['id']))
        {
            echo "<h2 class='text-center text-light'>Order ID not specified</h2>";
            exit();
        }
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_order_details.php");
    ?>

    </body>
</html>