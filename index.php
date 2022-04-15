<?php session_start(); ?>
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
    <link rel="stylesheet" href="/TechTronic/styles/homepage.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="h-100 text-center text-white bg-dark">

    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/menu.php"); ?>
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/products_carousel.php"); ?>


    <?php
        $query = "SELECT product_id, CONCAT(product_name_base, ' ', product_name_version) as name FROM products pd
            ORDER BY ( SELECT MAX((price - discount_price) / price) AS discount FROM color_versions cv
                            WHERE discount_price IS NOT NULL AND pd.product_id = cv.product_id
                    ) DESC LIMIT 5";
        $discount_products = $conn->get_data($query);
        if($discount_products)
        {
            echo '<a href="/TechTronic/products.php?discount=true" class="text-decoration-none text-light">
                    <h1 class=\'display-1\'>The Hottest Discounts Today</h1></a>';
            echo get_products_carousel($discount_products, $conn, 'discount');
        }

        $query = "SELECT product_id, CONCAT(product_name_base, ' ', product_name_version) as name FROM products pd 
                  WHERE (SELECT COUNT(*) FROM color_versions cv WHERE cv.product_id = pd.product_id) > 0
                  ORDER BY product_id DESC LIMIT 5";
        $newest_products = $conn->get_data($query);
        if($newest_products)
        {
            echo '<a href="/TechTronic/products.php?sort_by=5" class="text-decoration-none text-light">
                    <h1 class=\'display-1 responsive-margin\'>The Latest Products</h1></a>';
            echo get_products_carousel($newest_products, $conn, 'newest');
        }
    ?>
    <br><br>
</body>
</html>