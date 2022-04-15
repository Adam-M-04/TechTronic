<?php
    if(!isset($conn))
    {
        include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
        $conn = new Connection();
    }

    function get_products_carousel(array $products, Connection $conn, string $mode): string
    {
        $id = "carousel_indicators_$mode";
        $slides = '<div class="carousel-inner">';
        $indicators = "";
        for ($i=0; $i < count($products); ++$i)
        {
            $color_versions = $conn->get_data("SELECT * FROM color_versions LEFT JOIN colors USING (color_id)
                LEFT JOIN product_images pi on main_image_id = pi.image_id
                WHERE product_id = {$products[$i]->product_id} 
                ORDER BY IF(discount_price IS NOT NULL, discount_price, price) LIMIT 3");
            $colors_list = "<ul class=\"list-group fs-5\">";
            foreach ($color_versions as $cv)
            {
                $discount_price = $cv->discount_price ? "<span class='text-danger'>$".$cv->discount_price."</span>" : "";
                $price_line_through = $cv->discount_price ? "text-decoration-line-through" : "";
                $colors_list .= "<a href='/TechTronic/product/{$cv->cv_id}/' class=\"text-decoration-none\">
                                  <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                                    {$cv->color_name}
                                    <span>{$discount_price} <span class='$price_line_through'>\${$cv->price}</span></span>
                                  </li></a>";
            }
            $colors_list .= "</ul>";

            $url_name = ($products[$i]->name);
            $cv1 = $color_versions[0];
            $image_path = $cv1->image_path ?? "../card-image.png";
            if($mode == "discount")
            {
                $discount = intval(($cv1->price - $cv1->discount_price) / $cv1->price * 100);
                $main_paragraph = "<p class='fs-1'><span class='fs-4'>UP TO</span> 
                                    <span class='text-danger'>$discount%</span> OFF</p>";
            }
            else
            {
                $min_price = $cv1->discount_price ?? $cv1->price;
                $main_paragraph = "<p class='fs-1'><span class='fs-4'>FROM</span> <span class='text-primary'>$$min_price</span></p>";
            }

            $slides .= "<div class=\"carousel-item text-dark".($i==0?' active':'')."\">
                         <div class=\"card mb-3\">
                          <div class=\"row g-0\">
                            <div class='col-md-1'></div>
                            <div class=\"col-md-4\">
                              <img src=\"/TechTronic/images/product_images/{$image_path}\" 
                                class=\"img-fluid rounded-start carousel-image\" alt=\"product image\">
                            </div>
                            <div class=\"col-md-6\">
                              <div class=\"card-body\"> 
                                <a href='/TechTronic/products.php?product_name={$url_name}&exact_search=true' class='text-decoration-none'>
                                    <h5 class=\"card-title display-5 text-dark\">{$products[$i]->name}</h5>
                                </a>
                                $main_paragraph
                                <br>   
                                <div class='row'>
                                    <div class='col-1'></div>
                                    <div class='col-10'>$colors_list</div>
                                    <div class='col-1'></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                       </div>";
            $indicators .= '<button type="button" data-bs-target="#'.$id.'" data-bs-slide-to="'.$i.'"'.
                ($i==0?' class="active" aria-current="true"':'').'></button>';

        }
        $slides .= '</div>';

        return '<div class="container carousel-container">
                    <div id="'.$id.'" class="carousel carousel-dark slide" data-bs-ride="carousel">
                      <div class="carousel-indicators">
                        '.$indicators.'
                      </div>
                        '.$slides.'
                      <button class="carousel-control-prev" type="button" data-bs-target="#'.$id.'" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#'.$id.'" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                      </button>
                    </div>
                </div>';
    }