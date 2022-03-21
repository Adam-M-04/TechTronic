<?php

    function get_color_variants(int $id, object $conn): string
    {
        $versions = $conn->get_data("SELECT cv_id,color_name,price FROM `color_versions` 
                            INNER JOIN products USING(product_id) LEFT JOIN colors USING(color_id)
                            WHERE product_id = {$id}");

        $to_return = "<div class=\"dropdown\" style='margin-top: 10px;'>
                            <button class=\"btn btn-secondary dropdown-toggle btn-lg\" type=\"button\" id=\"dropdownMenuButton1\" 
                            data-bs-toggle=\"dropdown\" aria-expanded=\"false\" style='width: 182px;'>Color versions</button>
                            <ul class=\"dropdown-menu dropdown-menu-dark dropdown-menu-end\">";
        $len = count($versions);
        for($i = 0; $i < $len; ++$i)
        {
            $is_current = $versions[$i]->cv_id == $_GET["id"] ? " style='font-weight: 500;'" : "";
            $to_return .= "<li><a class='dropdown-item d-flex justify-content-between'$is_current href='/TechTronic/products/{$versions[$i]->cv_id}/'>
                                <span style='padding-right: 20px;'>{$versions[$i]->color_name}</span> <span>\${$versions[$i]->price}</span></a></li>";
            if($i != $len - 1) $to_return .= "<li><hr class=\"dropdown-divider\"></li>";
        }
        return $to_return."</ul></div>";
    }

    function get_carousel_with_images(array $images_array): string
    {
        if(count($images_array) == 0)
        {
            $tmp = new stdClass();
            $tmp->{"image_path"} = '../card-image.png';
            $images_array[] = $tmp;
        }
        $to_return = "<div id=\"carouselExampleIndicators\" class=\"carousel slide carousel-dark\" data-bs-ride=\"carousel\">";
        $len = count($images_array);
        $indicators = "<div class=\"carousel-indicators\" style='margin-bottom: -20px;'>";
        $images = "<div class=\"carousel-inner\">";

        for($i = 0; $i < $len; ++$i)
        {
            $indicators .= "<button type=\"button\" data-bs-target=\"#carouselExampleIndicators\" data-bs-slide-to=\"$i\" 
                    aria-label=\"Slide $i\"".($i==0?" class=\"active\" aria-current=\"true\"":"")."></button>";
            $images .= "<div class=\"carousel-item".($i==0?" active":"")."\">
                        <img style='height: 500px; object-fit: contain;' src=\"/TechTronic/images/product_images/{$images_array[$i]->image_path}\" class=\"d-block w-100\" alt=\"image $i\"></div>";
        }

        $buttons = "<button class=\"carousel-control-prev\" type=\"button\" data-bs-target=\"#carouselExampleIndicators\" 
                    data-bs-slide=\"prev\" style='margin-left: -20px;'><span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
                    <span class=\"visually-hidden\">Previous</span></button><button class=\"carousel-control-next\" 
                    type=\"button\" data-bs-target=\"#carouselExampleIndicators\" data-bs-slide=\"next\" style='margin-right: -20px;'>
                    <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span><span class=\"visually-hidden\">Next</span></button>";

        return $to_return.$indicators."</div>".$images."</div>".$buttons."</div>";
    }

    function get_specification(array $specs, object $product): string
    {
        $to_return = "<table class=\"table table-dark table-hover table-bordered product-specification-table\">
                        <thead class='table-light'><th colspan='2'>SPECIFICATION</th></thead>
                        <tr><td>$product->s_name_1</td><td>$product->s_value_1</td></tr>
                        <tr><td>$product->s_name_2</td><td>$product->s_value_2</td></tr>
                        <tr><td>$product->s_name_3</td><td>$product->s_value_3</td></tr>";
        foreach ($specs as $row)
        {
            $to_return .= "<tr><td>$row->specification_name</td><td>$row->specification_value</td></tr>";
        }
        $to_return .= "<tr><td>Warranty</td><td>".(isset($product->warranty) ? $product->warranty." months" : "No warranty")."</td></tr>";
        $to_return .= "<tr><td>Producer</td><td>$product->producer_name</td></tr>";
        return $to_return."</table>";
    }
