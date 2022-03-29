<?php

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $category_id = $_GET["category_id"] ?? -1;

    $query =
        "SELECT 
            cv.*, p.*, c.color_name, pi.image_path, 
            sn1.specification_name as s_name_1,
            sn2.specification_name as s_name_2,
            sn3.specification_name as s_name_3,
            sv1.specification_value as s_value_1,
            sv2.specification_value as s_value_2,
            sv3.specification_value as s_value_3
        FROM color_versions cv
        INNER JOIN products p USING (product_id)
        LEFT JOIN colors c USING (color_id)
        LEFT JOIN product_images pi ON cv.main_image_id = pi.image_id
        LEFT JOIN categories cat USING(category_id)
        INNER JOIN specification_names sn1 on cat.feature_1_name = sn1.sn_id
        INNER JOIN specification_names sn2 on cat.feature_2_name = sn2.sn_id
        INNER JOIN specification_names sn3 on cat.feature_3_name = sn3.sn_id
        INNER JOIN specification_values sv1 on p.feature_1_val = sv1.sv_id
        INNER JOIN specification_values sv2 on p.feature_2_val = sv2.sv_id
        INNER JOIN specification_values sv3 on p.feature_3_val = sv3.sv_id";

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/get_query_constraints.php");

    $products = $conn->get_data($query);

    if($products == []) echo "No products";
    else
    {
        foreach ($products as $product)
        {
            $image_path = $product->image_path == NULL ? "card-image.png" : "product_images/".$product->image_path;
            $color = $product->color_name ?? "unknown color";


            $price = number_format($product->price,2);
            $discount_price = $product->discount_price ? number_format($product->discount_price,2) : false;
            $price_HTML = "<small class='text-primary product-card-price'>$$price</small>";
            if($discount_price != false)
            {
                $price_HTML = "<div class='text-danger product-card-price'>$$discount_price
                    <span class='text-primary text-decoration-line-through old_price product-card-price-discount'>$$price</span></div>";
            }

            $cart_button = $product->amount > 0 ?
                "<button class='btn btn-outline-success' onclick='add_to_cart($product->cv_id)'>Add to cart</button>" :
                "<button class='btn btn-outline-secondary' disabled>Sold out</button>";

            echo <<< product
                <div class="card product-card">
                    <a href="/TechTronic/product/$product->cv_id/" style="text-decoration: none; height: 100%;">
                        <img src="/TechTronic/images/$image_path" class="card-img-top product-image" alt="product image">
                        <div class="card-body mt-auto">
                            <h5 class="card-title text-dark">$product->product_name_base $product->product_name_version</h5>
                            <p class="card-text text-dark">$color</p>
                        </div>
                    </a>
                    <div class="list-group">
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1" style="font-size: 18px;">$product->s_name_1</h5>
                            </div>
                            <p class="mb-1" style="text-align: left;">$product->s_value_1</p>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1" style="font-size: 18px;">$product->s_name_2</h5>
                            </div>
                            <p class="mb-1" style="text-align: left;">$product->s_value_2</p>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1" style="font-size: 18px;">$product->s_name_3</h5>
                            </div>
                            <p class="mb-1" style="text-align: left;">$product->s_value_3</p>
                        </div>
                    </div>
                    <div class="card-footer mt-auto d-flex justify-content-between align-items-center">
                        $price_HTML
                        $cart_button
                    </div>
                </div>
product;
        }
    }

    $conn->close();