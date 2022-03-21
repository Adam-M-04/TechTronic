<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/admin");
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
        <title>Categories - admin</title>
        <link rel="stylesheet" href="/TechTronic/styles/main.css">
        <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
        <link rel="stylesheet" href="/TechTronic/styles/admin-header.css">
        <link rel="stylesheet" href="/TechTronic/styles/admin-categories.css">
        <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/admin-menu.php"); ?>
    <h1 class="display-1 text-center text-light">Categories</h1>

    <div class="container-fluid d-flex justify-content-center flex-wrap">
        <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_categories_admin.php"); ?>
    </div>

    <?php
    $display = false;
    $message = "";
    $color = "success";
    if(isset($_GET['mode']) and isset($_GET['result'])){
        if($_GET['result'] == "failure")
        {
            $message =  "An error occurred";
            $color = "danger";
        }
        elseif($_GET['result'] == "success")
        {
            if($_GET['mode'] == "d") $message =  "Category deleted successfully";
            if($_GET['mode'] == "m") $message =  "Category modified successfully";
            if($_GET['mode'] == "a") $message =  "Category added successfully";
        }
        $display = true;
    }
    ?>

    <!-- Toast message -->
    <div class="toast align-items-center text-white bg-<?php echo $color; ?> border-0 position-absolute top-0 start-50 translate-middle-x"
         role="alert" aria-live="assertive" aria-atomic="true" id="toast">
        <div class="d-flex">
            <div class="toast-body">
                <?php echo $message; ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <?php
        if($display)
        {
            echo "<script>
                    const toast_message = new bootstrap.Toast(document.getElementById('toast'))
                    toast_message.show()
                  </script>";
        }
    ?>

    </body>
</html>