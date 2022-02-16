<?php
    session_start();
    if(!isset($_SESSION['user_id'])) echo "<script>opener.ReloadPage(); window.close();</script>";
?>
<!doctype html>
<html lang="en">
<head>
    <script>if(opener === null) history.back()</script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
    <title>Payment</title>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="h-100 text-center text-white bg-dark">

<?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_payment_content.php"); ?>

</body>
</html>