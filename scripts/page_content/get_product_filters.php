<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $base_link = "/TechTronic/products/";

    $search_query = htmlentities($_GET['product_name'] ?? '');
    $exact_search = boolval($_GET["exact_search"] ?? false);
    $sort_by = is_numeric($_GET["sort_by"] ?? '') ? intval($_GET["sort_by"]) : '';
    $min_price = is_numeric($_GET["min_price"] ?? '') ? floatval($_GET["min_price"]) : '';
    $max_price = is_numeric($_GET["max_price"] ?? '') ? floatval($_GET["max_price"]) : '';
    $producer_id = is_numeric($_GET['producer_id'] ?? false) ? intval($_GET['producer_id']) : -1;
    $category_id = is_numeric($_GET['category_id'] ?? false) ? intval($_GET['category_id']) : -1;
    $color = htmlentities($_GET['color'] ?? '');
    $hide_unavailable = boolval($_GET["hide_unavailable"] ?? false);
    $discount = $_GET['discount'] ?? false;
    $page = $_GET["page"] ?? 1;

    $dropdown_link = $base_link."?";
    $offcanvas_parameters = '';
    if($search_query)
    {
        $dropdown_link .= "&product_name=$search_query";
        $offcanvas_parameters .= "<input type='hidden' name='product_name' value='$search_query'>";
    }
    if($exact_search)
    {
        $dropdown_link .= "&exact_search=true";
        $offcanvas_parameters .= "<input type='hidden' name='exact_search' value='true'>";
    }
    if($min_price) $dropdown_link .= "&min_price=$min_price";
    if($max_price) $dropdown_link .= "&max_price=$max_price";
    if($producer_id != -1) $dropdown_link .= "&producer_id=$producer_id";
    if($color) $dropdown_link .= "&color=$color";
    if($category_id != -1) $dropdown_link .= "&category_id=$category_id";
    if($hide_unavailable) $dropdown_link .= "&hide_unavailable=true";

    $pagination_link = $dropdown_link;
    if($discount)
    {
        $dropdown_link .= "&discount=true";
        $pagination_link .= "&discount=true";
        $offcanvas_parameters .= "<input type='hidden' name='discount' value='true'>";
    }
    if($sort_by)
    {
        $pagination_link .= "&sort_by=$sort_by";
        $offcanvas_parameters .= "<input type='hidden' name='sort_by' value='$sort_by'>";
    }

    $producers = $conn->get_data("SELECT * FROM producers");
    $producers_select = '<select class="form-select form-select-lg" name="producer_id"><option value="-1"'.($producer_id==-1?' selected':'').'>All</option>';
    foreach ($producers as $producer)
    {
        $producers_select .= "<option value='{$producer->producer_id}'".($producer->producer_id == $producer_id ? ' selected':'').
                ">{$producer->producer_name}</option>";
    }
    $producers_select .= '</select>';

    $categories = $conn->get_data("SELECT * FROM categories");
    $categories_select = '<select class="form-select form-select-lg" name="category_id"><option value="-1"'.($category_id==-1?' selected':'').'>All</option>';
    foreach ($categories as $category)
    {
        $categories_select .= "<option value='{$category->category_id}'".($category->category_id == $category_id ? ' selected' : '')
            .">{$category->category_name}</option>";
    }
    $categories_select .= '</select>';

    $colors = $conn->get_data("SELECT color_name FROM colors");
    $colors_list = '<datalist id="colors_list">';
    foreach ($colors as $col)
    {
        $colors_list .= "<option>{$col->color_name}</option>";
    }
    $colors_list .= '</datalist>';

    $dropdown_titles = ['Name A-Z', 'Name Z-A', 'Price Ascending', 'Price Descending', 'Newest'];
    $dropdown_buttons = "";
    for ($i = 1; $i <= count($dropdown_titles); ++$i)
    {
        $dropdown_buttons .= "<li><a class=\"dropdown-item".($i==$sort_by?' active':'')."\" href=\"$dropdown_link&sort_by=$i\">
            {$dropdown_titles[$i-1]}</a></li>";
    }

    echo "<div class=\"container filters-buttons-container d-flex justify-content-center\" id='filters'>
            <button class=\"btn btn-lg btn-light filter-button\" data-bs-toggle=\"offcanvas\" data-bs-target=\"#filters_offcanvas\">Filters</button>

            <div class=\"dropdown text\">
                <button class=\"btn btn-lg btn-light dropdown-toggle filter-button\" type=\"button\" id=\"dropdownMenuButton1\"
                        data-bs-toggle=\"dropdown\" aria-expanded=\"false\">Sort By</button>
                <ul class=\"dropdown-menu dropdown-menu-dark\" aria-labelledby=\"dropdownMenuButton1\">
                    $dropdown_buttons
                </ul>
            </div>
        </div>
        <div class=\"offcanvas offcanvas-start bg-dark\" tabindex=\"-1\" id=\"filters_offcanvas\" aria-labelledby=\"offcanvasExampleLabel\">
            <div class=\"offcanvas-header\">
                <h2>Filters</h2>
                <button type='button' class='btn-close btn-close-white text-reset' data-bs-dismiss='offcanvas' aria-label='Close'></button>
            </div>
            <form method='get' action='$base_link' id='filters_form'>
            $offcanvas_parameters
            <div class=\"offcanvas-body\">
                <h4>Price <span class='text-primary'>$</span></h4>
                <div class='row'>
                    <div class='col'>
                        <label class='form-label'>Min</label>
                    </div>
                    <div class='col'>
                        <label class='form-label'>Max</label>
                    </div>
                </div>
                <div class='row'>
                    <div class='col'>
                        <input class='form-control form-control-lg' type='number' name='min_price' 
                            value='".($min_price ? number_format($min_price, 2, '.', ''):'')."'
                            min='0.01' max='100000' step='0.01' onchange='value=format_val(value)'>
                    </div>
                    <div class='col'>
                        <input class='form-control form-control-lg' type='number' name='max_price' 
                            value='".($max_price ? number_format($max_price, 2, '.', ''):''). "'
                            min='0.01' max='100000' step='0.01' onchange='value=format_val(value)'>
                    </div>
                    <script>
                        function format_val(val){return parseFloat(val).toFixed(2)}
                    </script>
                </div><br>
                
                <h4>Producer</h4>
                <div class='row'><div class='col'>$producers_select</div></div><br>
                
                <h4>Category</h4>
                <div class='row'><div class='col'>$categories_select</div></div><br>
                
                <h4>Color</h4>
                <div class='row'>
                    <div class='col'><input type='text' name='color' value='$color' class='form-control form-select-lg' list='colors_list'>
                </div></div><br>
                $colors_list
                
                <div class='row'>
                    <div class='col' style='margin-left: 10px;'>
                        <div class='form-check form-switch d-flex'>
                          <input class='form-check-input enlarge' type='checkbox' role='switch'
                            name='hide_unavailable'".($hide_unavailable?' checked':'').">
                          <label class='form-check-label checkbox-label'>
                            Hide unavailable products
                          </label>
                        </div>
                    </div>
                </div>
                
                <br><div class='row'><div class='col'><button class='btn btn-lg btn-success w-100'>Apply</button></div></div>
                <br><div class='row'><div class='col'><button class='btn btn-lg btn-secondary w-100'
                    onclick='reset_form(`filters_form`)'>Reset</button></div></div>
            </div>
            </form>
        </div>
        <script src='/TechTronic/scripts/JS/reset_form.js'></script>";
