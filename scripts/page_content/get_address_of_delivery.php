<?php
    function get_address_of_delivery(Object $order, Object $conn): string
    {
        if($order->delivery_type == 4)
            $query = "SELECT * FROM shops JOIN address JOIN us_states us USING(state_id) USING(address_id) WHERE shop_id = ".$order->deliver_to_shop;
        else
            $query = "SELECT * FROM address JOIN us_states us USING(state_id) WHERE address_id = ".$order->deliver_to_address;
        $delivery_to = $conn->get_data($query);
        if($delivery_to != []) $delivery_to = $delivery_to[0];
        else {echo "<h2>Error occurred</h2>";exit();}

        if($order->delivery_type == 4)
            return "$delivery_to->shop_name<br>$delivery_to->phone_number<br>$delivery_to->street<br>$delivery_to->city, $delivery_to->state_name, $delivery_to->zip";
        else
            return "$order->customer_name<br>$delivery_to->phone_number<br>$delivery_to->street<br>$delivery_to->city, $delivery_to->state_name, $delivery_to->zip";

    }