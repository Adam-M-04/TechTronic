<?php
    if(!isset($_GET['id'])) {header('location: /TechTronic/');exit();}

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $order = $conn->get_data("SELECT * FROM orders o
        JOIN order_delivery od on o.delivery_type = od.delivery_id
        JOIN order_payment op on o.payment_type = op.payment_id
        JOIN order_status os on o.order_status = os.status_id
        WHERE order_id = {$_GET['id']} AND user_id = {$_SESSION['user_id']}");
    if($order == [])
    {
        echo "<h1 style='margin-top: 30px;'>Order Not Found</h1>";
        exit();
    }
    else
    {
        $order = $order[0];
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_address_of_delivery.php");
        $address = get_address_of_delivery($order, $conn);

        $pay_button = '';
        if(!$order->is_paid && $order->payment_id != 3)
            $pay_button = "<button class='btn btn-lg btn-warning' style='width: 180px; margin: 10px;'
                onclick='open_payment_window($order->order_id)'>Pay</button>";


        $products = $conn->get_data(
            "SELECT op.*, CONCAT(p.product_name_base, ' ', p.product_name_version) as name, c.color_name
                FROM ordered_products op
                    LEFT JOIN color_versions cv USING (cv_id) 
                    LEFT JOIN products p USING (product_id)
                    LEFT JOIN colors c USING (color_id)
                WHERE order_id = ".$order->order_id
        );
        $products_list = "<ul class='list-group'>";
        foreach ($products as $product)
        {
            $text = $product->cv_id ? "$product->name <span class='text-muted'>($product->color_name)</span>" :
                "<span class='text-danger'>Deleted product</span>";
            $products_list .= "<li class='list-group-item d-flex justify-content-between' style='font-size: 20px;'>
                    <span>
                        <b>{$product->ordered_amount}x</b> $text
                    </span> 
                    <span class='text-primary'>$$product->value</span>
                </li>";
        }
        $products_list .= "</ul>";

        echo <<< details
        <div class="d-flex justify-content-center">
            <div class="bg-light text-dark" style="width: 100%; max-width: 800px; padding: 30px; border-radius: 10px;">
                <h1>Order placed</h1><br>
                <h4>Your order ID: $order->order_id</h4>
                <h5 class="text-muted">(Ordered: $order->date_of_order)</h5><br>
                
                <div class="row">
                    <div class="col-6">
                        <h4>$order->delivery_name</h4>
                        <p style="font-size: 20px;">$address</p>
                    </div>
                    <div class="col-6">
                    <h4>$order->payment_name</h4>
                    <p style="font-size: 20px;">
                        <strong>Value:</strong><span class="text-primary"> $$order->order_price</span><br>
                        <strong>Status:</strong> $order->status_name <br>
                        $pay_button
                    </p>
                    </div>
                </div>
                
                <br>
                <div>
                    <h4>Products:</h4>
                    $products_list
                </div>
            </div>
        </div>
details;

    }
