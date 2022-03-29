<?php
    function show_message()
    {
        echo "<div style='display: flex; justify-content: center;' id='message_box'>";
        if(isset($_GET['mes']))
        {
            $text = match ($_GET['mes']) {
                "1" => "The content of your cart have changed",
                "2" => "Not enough products in stock",
                "3" => "Select delivery method",
                "4" => "Select payment method",
                "5" => "Select valid shop",
                default => "An error occurred. Please try again.",
            };
            echo "<div class=\"alert alert-danger message\" role=\"alert\">$text</div>";
        }
        echo "</div>";
    }

    show_message();

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/check_amount_in_cart.php");
    $conn = new Connection();

    $products_in_cart = $conn->get_data("SELECT c.*,cv.amount as available_amount, cv.price, cl.color_name,
                CONCAT(pr.product_name_base,' ',pr.product_name_version) as name, pi.image_path
            FROM cart c
            JOIN color_versions cv USING (cv_id)
            JOIN products pr USING (product_id)
            LEFT JOIN product_images pi on cv.main_image_id = pi.image_id
            LEFT JOIN colors cl USING (color_id)
            WHERE user_id = {$_SESSION["user_id"]} AND cv.amount > 0");

    $ordered_items = $conn->get_data("SELECT SUM(c.amount * IF(cv.discount_price, cv.discount_price, cv.price)) as price, SUM(c.amount) as count
        FROM cart c JOIN color_versions cv using (cv_id) 
        WHERE cv.amount > 0 AND user_id = {$_SESSION['user_id']}")[0];

    $delivery_options = $conn->get_data("SELECT delivery_name, delivery_description, icon,
            IF({$ordered_items->price} >= min_order_value AND min_order_value != -1, 'Free', delivery_cost) as delivery_cost FROM order_delivery");

    $user_address = $conn->get_data(
        "SELECT a.*, s.state_name, CONCAT(u.first_name, ' ', u.last_name) as name 
                FROM users u JOIN address a USING (address_id) JOIN us_states s USING (state_id)
                WHERE user_id = {$_SESSION['user_id']}"
    );

    $shops = $conn->get_data("SELECT * FROM shops JOIN address USING (address_id) JOIN us_states USING (state_id) ORDER BY shop_name");

    $payment_options = $conn->get_data("SELECT * FROM order_payment");

    if($products_in_cart != [])
    {
        #Delivery options
        $JS_prices_array = "[";
        echo "<h3>Select delivery</h3><div class='d-flex justify-content-center'>
            <ol class=\"list-group delivery-options-list\">";
        for ($i=0; $i<count($delivery_options); $i++)
        {
            echo "<li class=\"list-group-item delivery-option\" onclick=\"form_managing.delivery_manager.change_delivery($i+1)\">
                        <span style='text-align: left;'>
                            <img src='/TechTronic/images/{$delivery_options[$i]->icon}' class='delivery-icon'>
                            <strong>{$delivery_options[$i]->delivery_name}</strong> ({$delivery_options[$i]->delivery_description})
                        </span>
                  <strong>\${$delivery_options[$i]->delivery_cost}</strong></li>";
            $JS_prices_array .= ($delivery_options[$i]->delivery_cost == "Free" ? "0":$delivery_options[$i]->delivery_cost).
                ($i < count($delivery_options) - 1 ? "," : "");
        }
        echo "</ol></div>";
        $JS_prices_array .= "]";

        #Address
        echo "<div class='d-flex justify-content-center flex-wrap'><h3 style='width: 100%;' id='address_title'>Your Address</h3>
            <div class='user_address bg-light text-dark' id='address_box'>";
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_user_address.php");
        echo "</div></div>";

        #Shops
        echo "<div class='modal fade' tabindex='-1' id='shops_modal'>
                <div class='modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable'><div class='modal-content text-dark'>
                <div class='modal-header'>
                    <h3 class='modal-title' style='margin-top: 0px;'>Stationary Stores</h3>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'><div class='list-group list-group-flush'>";
        foreach ($shops as $shop)
        {
            echo "<div class='list-group-item d-flex justify-content-between flex-wrap'>
                    <h4 class='flex-fill shop-title'onclick='form_managing.delivery_manager.address_manager.shop_change_handler($shop->shop_id)'>
                        $shop->shop_name</h4>
                    <img src='/TechTronic/images/arrow_down.svg' data-bs-toggle=\"collapse\" class='collapse_address_arrow'
                            data-bs-target=\"#shop_address_$shop->shop_id\" aria-expanded=\"false\" 
                            aria-controls=\"shop_address_$shop->shop_id\">
                    <div class='collapse w-100' id='shop_address_$shop->shop_id'>
                        <div class='card card-body' style='font-size: 18px;'>
                            <p>$shop->phone_number</p>
                            <p>$shop->street</p>
                            <p>$shop->city, $shop->state_name, $shop->zip</p>
                        </div>
                    </div>
                  </div>";
        }
        echo "</div></div></div></div></div>
            <script>const shops_modal = new bootstrap.Modal(document.getElementById('shops_modal'))</script>";

        #Payment options
        echo "<h3>Select Payment</h3><div class='d-flex justify-content-center'>
            <ol class=\"list-group delivery-options-list\">";
        for ($i=0; $i<count($payment_options); $i++)
        {
            echo "<li class=\"list-group-item payment-option\" onclick=\"form_managing.payment_manager.change_payment($i+1)\">
                        <span style='text-align: left;'>
                            <img src='/TechTronic/images/{$payment_options[$i]->icon}' class='payment-icon'>
                            <strong>{$payment_options[$i]->payment_name}</strong>
                        </span>
                  <span class='payment-description'>{$payment_options[$i]->payment_description}</span></li>";
        }
        echo "</ol></div>";

        #Ordered products
        $products = [];
        echo "<h3>The products you order</h3>
                <div class='d-flex justify-content-center'><ol class='products-list list-group'>";
        foreach ($products_in_cart as $product)
        {
            $img_src = isset($product->image_path) ? "product_images/$product->image_path" : "card-image.png";
            $price = number_format($product->price,2);
            $items = $product->amount == 1 ? "item" : "items";
            echo <<< product
                <li class="list-group-item bg-light text-dark d-flex justify-content-between align-items-center flex-nowrap">
                        <div class="product-image-container">
                            <img src="/TechTronic/images/$img_src" class="img-fluid product-image" alt="product image">
                        </div>
                        <div class="product-name">
                            <h5 class="card-title text-dark">$product->name <span class="text-muted">($product->color_name)</span></h5>
                        </div>
                        <div class="product-price">
                            <h5 class="text-muted product-quantity">($product->amount<span class="items_span"> $items</span>)</h5>
                            <h5 class='text-primary'>$$price</h5>
                        </div>
                </li>
product;
            $products[$product->cv_id] = $product->amount;
        }

        $order_value_formatted = number_format($ordered_items->price,2);
        $products = json_encode($products);
        echo "</ol></div><div class='order_summary bg-dark border border-light'>
                <h2 class='text-light order_summary_text'>
                    Value:&nbsp<span class='text-primary' id='order-value'>$$order_value_formatted</span>
                    <span class='text-muted'>&nbsp({$ordered_items->count}<span class='items_text'> item".($ordered_items->count==1?"":"s")."</span>)</span>
                </h2>
                <form method='post' action='/TechTronic/scripts/order_processing.php' id='order_form'>
                <input type='hidden' name='products' value='$products'>
                <input type='hidden' name='delivery' value='-1'>
                <input type='hidden' name='payment'  value='-1'>
                <input type='hidden' name='shop_id'  value='-1'>
                <button class='btn btn-lg btn-success' type='submit' style='width: 100px;margin-right: -5px;'>Buy</button>
              </form>
              </div>
              <script src='/TechTronic/scripts/JS/order_details.js'></script>
              <script>
                  const form_managing = new form_manager({$ordered_items->price}, $JS_prices_array)
              </script>";
    }
    else
    {
        header("location: /TechTronic/cart.php");
        exit();
    }

    $conn->close();
