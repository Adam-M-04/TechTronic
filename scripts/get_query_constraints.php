<?php
    if ($category_id != -1) $query .= " WHERE category_id = ".$category_id;
    else $query .= " WHERE 1";

    if(isset($_GET["product_name"]))
    {
        $string = strtolower(htmlentities($_GET["product_name"]));
        $query .= " AND LOWER(CONCAT(product_name_base, ' ', product_name_version)) LIKE '%$string%'";
    }
