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
    <link rel="icon" type="image/png" href="/TechTronic/images/favicon.ico"/>
    <title>Payment</title>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="h-100 text-center text-white bg-dark">

<?php
    if(!isset($_POST['id']))
    {
        echo "<h2>Error occurred</h2>";
        exit();
    }
    $order_id = (int)$_POST['id'];

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $conn->obj->begin_transaction();
    $conn->obj->autocommit(false);
    if($conn->query("UPDATE orders SET is_paid = true, order_status = 2 WHERE is_paid = false AND order_id = $order_id AND user_id = {$_SESSION['user_id']}"))
    {
        $conn->obj->commit();
        echo "<img src='/TechTronic/images/successful-icon.svg' style='width: calc(100% - 100px); margin: 50px;'><h2>Payment made successfully</h2>";
        echo "<script>opener.ReloadPage(); setTimeout(()=>{window.close()}, 3000)</script>";
    }
    else
    {
        $conn->obj->rollback();
        echo "<h2>Something went wrong</h2>";
    }
?>

</body>
</html>