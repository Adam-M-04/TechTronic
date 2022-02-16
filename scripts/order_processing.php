<?php

    # Function closes connection and go back to page 'order_details' with error code
    function go_back(string $err_code, object $conn, bool $rollback = true): void
    {
        if($rollback) $conn->obj->rollback();
        header("location: /TechTronic/order_details.php?mes=".$err_code);
        $conn->close();
        exit();
    }

    # Starting session and checking if user is logged in
    session_start();
    if (!isset($_SESSION["user_id"])){header("location: /TechTronic/cart.php"); exit();}

    include_once ("sql_connection.php");
    $conn = new Connection();

    # Checking if selected delivery and payment methods are correct
    $delivery_method = $payment_method = null;
    $delivery_data = $conn->get_data("SELECT delivery_id,min_order_value,delivery_cost FROM order_delivery WHERE delivery_id = {$_POST['delivery']}");
    if(count($delivery_data))
    {
        $delivery_method = $_POST['delivery'];
        $delivery_data = $delivery_data[0];
    }
    else go_back("3", $conn, false);
    if(count($conn->get_data("SELECT payment_id FROM order_payment WHERE payment_id = {$_POST['payment']}")) != 0)
        $payment_method = $_POST['payment'];
    else go_back("4", $conn, false);


    $conn->obj->begin_transaction();
    $conn->obj->autocommit(false);

    $selected_shop_id = "NULL";
    $address_id = "NULL";
    #Check if selected shop exist
    if((int)$delivery_method == 4)
    {
        $selected_shop_id = (int)$_POST['shop_id'];
        if(!count($conn->get_data("SELECT * FROM shops WHERE shop_id = ".$selected_shop_id)))
        {
            go_back(5, $conn, false); # shop doesn't exist
        }
    }
    else
    {
        $user_address = $conn->get_data("SELECT a.* FROM users JOIN address a USING (address_id) WHERE user_id = ".$_SESSION['user_id']);
        if(count($user_address))
        {
            $user_address = $user_address[0];
            $insert_address = $conn->query("INSERT INTO address (state_id, city, zip, street, phone_number) 
                VALUES ($user_address->state_id, '$user_address->city', '$user_address->zip', '$user_address->street', '$user_address->phone_number')");
            if($insert_address)
            {
                $address_id = $conn->obj->insert_id;
            }
            else go_back(0, $conn); # Error while inserting address to database
        }
        else go_back(0, $conn); # User address not found
    }

    # Getting current products in user's cart from database
    $products_in_cart = $conn->get_data("SELECT c.*, cv.amount as available_amount, cv.price 
        FROM cart c JOIN color_versions cv USING(cv_id) 
        WHERE user_id = {$_SESSION['user_id']} AND cv.amount > 0");
    if(count($products_in_cart) == 0) go_back(0, $conn);

    # Getting products sent from previous page
    $sent_products = json_decode($_POST["products"], true);
    if($sent_products == NULL) {
        go_back("0", $conn, false);
    }

    $order_price = 0;

    foreach ($products_in_cart as $product)
    {
        if(array_key_exists($product->cv_id, $sent_products))
        {
            $selected_amount = (int)$sent_products[$product->cv_id];
            if($selected_amount <= $product->available_amount)
            {
                $conn->obj->query("UPDATE color_versions SET amount = amount - $selected_amount WHERE cv_id = $product->cv_id");
                unset($sent_products[$product->cv_id]);
                $order_price += $product->price * $product->amount;
            }
            else
            {
                go_back("2", $conn); # Not enough products in stock
            }
        }
        else
        {
            go_back("1", $conn); # the items in the cart are not the same as the items sent
        }
    }

    if($order_price < $delivery_data->min_order_value || (int)$delivery_data->min_order_value == -1) $order_price += $delivery_data->delivery_cost;

    if(count($sent_products) > 0)
    {
        go_back("1", $conn); # the items in the cart are not the same as the items sent
    }
    else
    {
        # Deleting from user's cart ordered items
        $bool = $conn->query("DELETE c FROM cart c JOIN color_versions cv USING(cv_id)
            WHERE user_id = {$_SESSION['user_id']} AND cv.amount > 0");

        $status = $payment_method == 3 ? 2 : 1;
        # Inserting new order into the database
        $bool = $conn->query("INSERT INTO orders 
            (user_id,customer_name,date_of_order,delivery_type,deliver_to_address,deliver_to_shop,payment_type,order_status,order_price,is_paid)
            VALUES ({$_SESSION['user_id']}, '{$_SESSION['user_name']}', NOW(), {$delivery_method},{$address_id},{$selected_shop_id}, 
                    {$payment_method}, {$status}, {$order_price}, false)") and $bool;

        $order_id = $conn->obj->insert_id;

        foreach ($products_in_cart as $product)
        {
            $bool = $conn->obj->query("INSERT INTO ordered_products (order_id, cv_id, ordered_amount, value) 
                VALUES ({$order_id}, {$product->cv_id}, {$product->amount}, {$product->price})") and $bool;
        }

        if($bool) $conn->obj->commit();
        else go_back("0", $conn);
        header("location: /TechTronic/messages/purchase_message.php?id=".$order_id);
    }

    $conn->close();
