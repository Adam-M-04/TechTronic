<?php
    function get_number_of_days($option)
    {
        return match ($option) {
            1 => 0,
            2 => 1,
            3 => 7,
            4 => 30,
            default => ""
        };
    }

    $filter_by_date = true;
    $where = " WHERE 1";
    if(isset($_GET['status_id']))
    {
        if($_GET['status_id']) $where .= " AND status_id = ".(intval($_GET['status_id']));
    }
    if(isset($_GET['period_id']))
    {
        $campare_sign = $_GET['period_id'] == 2 ? "=" : "<=";
        if($_GET['period_id'])
        {
            $where .= " AND DATEDIFF(CURDATE(), date_of_order) $campare_sign ".get_number_of_days(intval($_GET['period_id']));
            $filter_by_date = false;
        }
    }
    if (isset($_GET['specific_day']) and $filter_by_date)
    {
        if($_GET['specific_day']) $where .= " AND DATE(date_of_order) = '".htmlentities($_GET['specific_day']."'");
    }

    $orders = $conn->get_data("SELECT order_id, customer_name, status_name, order_price, date_of_order FROM orders
        JOIN order_status os on orders.order_status = os.status_id".$where);

    if(!$orders)
    {
        echo "<h3 class='text-light text-center'>No Orders Found!</h3>";
    }
    else
    {
        echo '<script src="/TechTronic/scripts/JS/orders_hover_handler.js"></script>
            <div class="container"><ul class="list-group">';

        foreach ($orders as $order)
        {

            echo "<li class='list-group-item' onmouseenter='mouse_hover_handler()' onmouseleave='mouse_hover_handler()'>
                <a href='/TechTronic/admin/order/{$order->order_id}/' class='text-decoration-none d-flex text-reset'>
                <div class='col-6 d-flex align-items-center flex-wrap'>
                    <div class='w-100'>
                        <p class='fs-3'><span class='text-secondary'>#</span>{$order->order_id} 
                        <span class='text-primary fs-5'>{$order->date_of_order} </span></p>
                    </div>
                    <div class='w-100'>
                        <p class='fs-4'><span class='text-secondary'>Customer:</span> {$order->customer_name}</p>
                    </div>
                </div>
                <div class='col-6 d-flex align-items-center flex-wrap'>
                    <div class='w-100'>
                        <p class='fs-2 text-end text-primary'>\${$order->order_price}</p>
                    </div>
                    <div class='w-100'>
                        <p class='fs-4 text-end text-dark'>{$order->status_name}</p>
                    </div>
                </div>
              </a></li>";
        }

        echo "</ul></div><br><br><br>";
    }
