<?php
    session_start();
    if(!isset($_SESSION['user_id'])) {echo -1; exit();}

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $shop_id = (int)$_GET['id'];

    $shop_address = $conn->get_data(
        "SELECT * FROM shops JOIN address USING (address_id) JOIN us_states USING (state_id) WHERE shop_id = $shop_id"
    );

    if($shop_address != [])
    {
        $shop_address = $shop_address[0];
        echo "<h4>$shop_address->shop_name</h4>
                <p>$shop_address->phone_number</p>
                <p>$shop_address->street</p>
                <p>$shop_address->city, $shop_address->state_name, $shop_address->zip</p>
                <button type='button' class='btn-close btn-lg remove-shop' aria-label='Close' 
                    onclick='form_managing.delivery_manager.address_manager.remove_selected_shop()'></button>";
    }
    else
    {
        echo -1;
    }
