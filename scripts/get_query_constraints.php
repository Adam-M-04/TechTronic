<?php
    if ($category_id != -1) $query .= " WHERE category_id = ".$category_id;
    else $query .= " WHERE 1";

    if($search_query)
    {
        $percent = $exact_search ? "" : "%";
        $string = trim(strtolower($search_query));
        $query .= " AND LOWER(CONCAT(product_name_base, ' ', product_name_version)) LIKE '$percent$string$percent'";
    }
    if($min_price)
    {
        $query .= " AND IF(discount_price IS NULL, price, discount_price) > $min_price";
    }
    if($max_price)
    {
        $query .= " AND IF(discount_price IS NULL, price, discount_price) < $max_price";
    }
    if($producer_id != -1)
    {
        $query .= " AND producer_id = $producer_id";
    }
    if($color)
    {
        $query .= " AND color_name = '$color'";
    }
    if($discount)
    {
        $query .= " AND discount_price IS NOT NULL";
    }
    if($hide_unavailable)
    {
        $query .= " AND amount > 0";
    }

    if($sort_by)
    {
        $val = match ($sort_by){
            1 => "CONCAT(product_name_base,product_name_version)",
            2 => "CONCAT(product_name_base,product_name_version) DESC",
            3 => "IF(discount_price IS NULL, price, discount_price)",
            4 => "IF(discount_price IS NULL, price, discount_price) DESC",
            5 => "cv_id DESC"
        };
        $query .= " ORDER BY $val";
    }
