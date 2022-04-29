<?php
    $selected_status = intval($_GET['status_id'] ?? -1);
    $status_list = $conn->get_data("SELECT * FROM order_status");
    $status_dropdown = '<h4 class="text-center">Order Status</h4>
                        <select class="form-select form-select-lg" name="status_id">
                        <option value="0">All</option>';
    foreach ($status_list as $status)
    {
        $status_dropdown .= "<option value='{$status->status_id}' ".($selected_status==$status->status_id?"selected":'').">{$status->status_name}</option>";
    }
    $status_dropdown .= "</select>";

    $periods_of_time = ["All", "Today", "Yesterday", "Last 7 days", "Last 30 days"];
    $period_options_HTML = "";

    $period_id = $_GET['period_id'] ?? 0;
    for($i = 0; $i < count($periods_of_time); ++$i)
    {
        $period_options_HTML .= "<option value='$i'".
            ($i == $period_id ? " selected" : "").">{$periods_of_time[$i]}</option>";
    }

    $selected_day = "";
    if (isset($_GET['specific_day']) and $period_id == 0) {
        $selected_day = "value='".$_GET['specific_day']."'";
    }

    echo '<div class="container text-center" style=""><button class="btn btn-lg btn-secondary" type="button" 
            data-bs-toggle="offcanvas" data-bs-target="#offcanvas_filters">Filters</button></div><br><br>';

    echo "<div class=\"offcanvas bg-dark text-light offcanvas-start\" tabindex=\"-1\" id=\"offcanvas_filters\" aria-labelledby=\"offcanvasRightLabel\">
            <div class=\"offcanvas-header\">
                <h2>Filters</h2>
                <button type=\"button\" class=\"btn-close btn-close-white text-reset\" data-bs-dismiss=\"offcanvas\" aria-label=\"Close\"></button>
            </div>
            <form method='get' action='#' id='orders_filters'>
            <div class=\"offcanvas-body\">
                $status_dropdown
                <br><br>
                <h4 class='text-center'>Period of time</h4>
                <select class='form-select form-select-lg' name='period_id' onchange='document.getElementsByName(`specific_day`)[0].value=``'>
                    $period_options_HTML
                </select>
                <br>
                <h4 class='text-center'>Or select a specific day</h4>
                <input type='date' class='form-control form-control-lg' name='specific_day' $selected_day
                     onchange='document.getElementsByName(`period_id`)[0].value=`0`'>
                <br><br>
                
                <button class='btn btn-lg btn-success w-100'>Apply</button><br><br>
                <button class='btn btn-lg btn-secondary w-100' onclick='reset_form(`orders_filters`)'>Reset</button>
            </div>
            </form>
        </div>
        <script src='/TechTronic/scripts/JS/reset_form.js'></script>";
