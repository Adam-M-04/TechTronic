<?php

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $query =
       "SELECT * FROM orders 
            JOIN order_status os on orders.order_status = os.status_id
            JOIN order_delivery od on orders.delivery_type = od.delivery_id
            JOIN order_payment op on orders.payment_type = op.payment_id
        WHERE user_id = {$_SESSION['user_id']} ORDER BY date_of_order DESC";

    $orders = $conn->get_data($query);

    if($orders == [])
    {
        echo "<h1>You don't have any orders yet</h1>";
    }
    else
    {
        echo "<h1>Your Orders</h1>";
        echo '<div class="d-flex justify-content-center"><ul class="list-group" id="orders_list">';
        foreach ($orders as $order)
        {
            include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_address_of_delivery.php");
            $address = get_address_of_delivery($order, $conn);

            # List of products in order
            $delivery_value = $order->order_price;
            $products = $conn->get_data(
                "SELECT op.*, CONCAT(p.product_name_base, ' ', p.product_name_version) as name, c.color_name, cv.price
                FROM ordered_products op
                    JOIN color_versions cv USING (cv_id) 
                    JOIN products p USING (product_id)
                    JOIN colors c USING (color_id)
                WHERE order_id = ".$order->order_id
            );
            $products_list = "<ul class='list-group'>";
            foreach ($products as $product)
            {
                $products_list .= "<li class='list-group-item d-flex justify-content-between' style='font-size: 20px;'>
                    <span>
                        <b>{$product->ordered_amount}x</b> $product->name <span class='text-muted'>($product->color_name)</span>
                    </span> 
                    <span class='text-primary'>$$product->value</span>
                </li>";
                $delivery_value -= $product->price * $product->ordered_amount;
            }
            $products_list .= "<li class='list-group-item d-flex justify-content-between' style='font-size: 20px;'>
                    <b>Delivery: </b>
                        <span class='text-primary'>$$delivery_value
                    </span>
                </li></ul>";

            $pay_button = '';
            if(!$order->is_paid && $order->payment_id != 3)
                $pay_button = "<button class='btn btn-lg btn-warning' style='width: 180px; margin: 10px;'
                    onclick='open_payment_window($order->order_id)'>Pay</button>";

            $include_year = substr($order->date_of_order, 0, 4) == date('Y') ? "" : " Y";
            $formated_date = DateTime::createFromFormat('Y-m-d H:i:s', $order->date_of_order)->format('d F'.$include_year);
            echo "<li class='list-group-item user-order' data-bs-toggle='collapse' data-bs-target='#order_details_$order->order_id' 
                        aria-expanded='false' aria-controls='order_details_$order->order_id'>
                    <div class='d-flex justify-content-between'>
                        <h3>$formated_date</h3> <h3 class='text-primary'>$$order->order_price</h3>
                    </div>
                    <div class='d-flex justify-content-between' style='font-size: 20px;'>
                        <p>Order ID: $order->order_id</p> <b>$order->status_name</b>
                    </div>
                    <div class='collapse' id='order_details_$order->order_id'>
                        <div class='card card-body'>
                            <div class='row'>
                                <div class='col-6'>
                                    <h4>$order->delivery_name</h4>
                                    <p style='font-size: 20px;'>$address</p>
                                </div>
                                <div class='col-6'>
                                <h4>$order->payment_name</h4>
                                <p style='font-size: 20px;'>
                                    <strong>Value:</strong><span class='text-primary'> $$order->order_price</span><br>
                                    <strong>Status:</strong> $order->status_name <br>
                                    $pay_button
                                </p>
                                </div>
                            </div>
                            $products_list
                        </div>
                    </div>
                  </li>";
        }
        echo '</ul></div>';

    }

    $conn->close();