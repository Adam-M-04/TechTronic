<?php
    if(!isset($conn))
    {
        include_once ("sql_connection.php");
        $conn = new Connection();
    }

    $conn->query( "UPDATE cart INNER JOIN color_versions USING (cv_id) 
        SET cart.amount = IF (cart.amount > color_versions.amount AND color_versions.amount > 0, color_versions.amount, cart.amount)
        WHERE user_id = {$_SESSION['user_id']}");

