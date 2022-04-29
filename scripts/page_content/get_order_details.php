<?php
    $id = $_GET['id'];

    $query = "SELECT * FROM orders o
         JOIN order_delivery od on o.delivery_type = od.delivery_id
         JOIN order_payment op on o.payment_type = op.payment_id
         LEFT JOIN shops s on o.deliver_to_shop = s.shop_id
         LEFT JOIN address a on o.deliver_to_address = a.address_id
         WHERE order_id = $id";
    $order_details = $conn->get_data($query);

    if(!$order_details)
    {
        echo "<h2 class='text-center text-light'>Order not found!</h2>";
        exit();
    }
    $order_details = $order_details[0];

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/get_address_of_delivery.php");
    $address = get_address_of_delivery($order_details, $conn);

    $delivery_cost = $order_details->order_price;
    $ordered_products = $conn->get_data("SELECT * FROM ordered_products op
         JOIN color_versions cv USING (cv_id)
         JOIN products p USING (product_id)
         WHERE order_id = ".$order_details->order_id);
    $products_HTML = '<ul class="list-group list-group-flush">';
    foreach ($ordered_products as $product)
    {
        $products_HTML .= "<li class='list-group-item d-flex justify-content-between'>
                    <div class='d-flex'><strong class='product_id'>#$product->cv_id</strong> $product->product_name_base $product->product_name_version</div>
                    <div>$product->ordered_amount x <span class='text-primary'>$$product->value</span></div>
                </li>";
        $delivery_cost -= $product->ordered_amount * $product->value;
    }
    $delivery_cost = $delivery_cost == 0 ? "FREE" : "$".$delivery_cost;
    $products_HTML .= "<li class='list-group-item d-flex justify-content-between'>
                    <strong class='product_id'>Delivery cost:</strong>
                    <span class='text-primary'>$delivery_cost</span>
                </li></ul>";

    $status_list = $conn->get_data("SELECT * FROM order_status");
    $status_HTML = '<select class="form-select form-select-lg w-75" onchange="change_order_status('.$id.' ,value)">';
    foreach ($status_list as $status)
    {
        $selected = $status->status_id == $order_details->order_status ? " selected" : "";
        $status_HTML .= "<option value='$status->status_id'$selected>$status->status_name</option>";
    }
    $status_HTML .= "</select>";

    echo "<div class='container'>
            <div class='bg-light rounded div-padding'>
                <div class='d-flex justify-content-between fs-2'>
                    <strong>ID#{$order_details->order_id}</strong>
                    <span class='text-primary'>{$order_details->date_of_order}</span>
                </div>
                
                <div class='row order-main'>
                    <div class='col-6 text-center fs-4 border border-2 rounded-start'>
                        <strong class='text-uppercase fs-3'>{$order_details->delivery_name}</strong><br>
                        $address
                    </div>
                    <div class='col-6 text-center fs-4 border border-2 rounded-end border-start-0'>
                        <div class='row'>
                            <div class='col-6 text-end'><strong>Payment:</strong></div>
                            <div class='col-6 text-start'>$order_details->payment_name</div>
                        </div>
                        <div class='row'>
                            <div class='col-6 text-end'><strong>Value:</strong></div>
                            <div class='col-6 text-start'><span class='text-primary'>$$order_details->order_price</span></div>
                        </div>
                        <div class='row'>
                            <strong class='order-status'>Status</strong><br>
                            <div class='d-flex justify-content-center'>$status_HTML</div>
                        </div>
                    </div>
                </div>
                <br>
                <div class='row border border-2 rounded fs-4'>
                    $products_HTML
                </div>
            </div>  
          </div>
          <script src='/TechTronic/scripts/JS/change_order_status.js'></script>";
