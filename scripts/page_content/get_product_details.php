<?php
    $product_id = $_GET["id"] ?? -1;

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/product_view_components.php");

    $result = $conn->get_data(
        "SELECT 
                    cv.*,
                    p.product_id, p.producer_id, CONCAT(p.product_name_base, ' ', p.product_name_version) as name, p.warranty, p.product_name_base,
                    prod.producer_name, cat.category_id, cat.category_name, col.color_name, 
                    sn1.specification_name as s_name_1, sn2.specification_name as s_name_2, sn3.specification_name as s_name_3,
                    sv1.specification_value as s_value_1, sv2.specification_value as s_value_2, sv3.specification_value as s_value_3
                    FROM color_versions cv
                    INNER JOIN products p USING (product_id)
                    LEFT JOIN producers prod using (producer_id)
                    LEFT JOIN categories cat using (category_id)
                    LEFT JOIN colors col using (color_id)
                    INNER JOIN specification_names sn1 on cat.feature_1_name = sn1.sn_id
                    INNER JOIN specification_names sn2 on cat.feature_2_name = sn2.sn_id
                    INNER JOIN specification_names sn3 on cat.feature_3_name = sn3.sn_id
                    INNER JOIN specification_values sv1 on p.feature_1_val = sv1.sv_id
                    INNER JOIN specification_values sv2 on p.feature_2_val = sv2.sv_id
                    INNER JOIN specification_values sv3 on p.feature_3_val = sv3.sv_id
                    WHERE cv.cv_id = $product_id"
    );

    $free_delivery_min_value = $conn->get_data("SELECT min_order_value FROM order_delivery 
            WHERE min_order_value != -1.00 ORDER BY min_order_value")[0];

    if(count($result) == 0)
    {
        echo "<h2>Product not found<h2>";
    }
    else
    {
        $product = $result[0];
        $price = "$".number_format(intval($product->price)). "<sup style='color: #676767; font-size: 24px;'>" .(substr((string)$product->price, -2))."</sup>";
        $discount_price = "";
        if($product->discount_price)
        {
            $diff = $product->price - $product->discount_price;
            $price = "<span class='text-decoration-line-through' style='font-size: 30px;'>$".number_format($product->price, 2)."</span>";
            $discount_price = "<span class='text-danger' title='$$diff off' 
                data-bs-toggle='tooltip'>$".number_format(intval($product->discount_price)).
                "<sup style='font-size: 24px;'>" .(substr((string)$product->discount_price, -2))."</sup></span>";
        }

        $color_versions = get_color_variants($product->product_id, $conn);
        $images_carousel = get_carousel_with_images($conn->get_data("SELECT image_path FROM product_images WHERE cv_id={$product_id}"));

        $specs = get_specification($conn->get_data("SELECT specification_name,specification_value FROM product_specification ps
                    JOIN specification_names USING (sn_id) JOIN specification_values USING (sv_id) 
                    WHERE product_id = $product->product_id ORDER BY ps.id") , $product);

        $category = isset($product->category_name) ? "<span class=\"text-dark\"> | Category: </span><span class=\"text-muted\">$product->category_name</span>" : '';

        if($product->amount == 0) $amount_background = "secondary";
        elseif ($product->amount <= 5) $amount_background = "danger";
        elseif ($product->amount <= 10) $amount_background = "warning";
        else $amount_background = "success";

        $start_value = min($product->amount, 1);
        $disabled_amount = $product->amount > 0 ? "" : "disabled";
        $button_text = $product->amount > 0 ? "Add To Cart" : "Sold Out";
        $button_color = $product->amount > 0 ? "success" : "secondary";
        $product_name = html_entity_decode($product->name);
        $free_delivery_text = $free_delivery_min_value->min_order_value == "0.00" ? "Free shipping for all products" :
            "Free shipping when ordering an item or items valued at $".($free_delivery_min_value->min_order_value)." or more";

        echo <<< product
            <script id="title_change">
                document.title = `$product_name - TechTronic`
                document.getElementById('title_change').remove();
            </script>
            <div class="card mb-3 product-view-card">
                <div class="row g-0">
                    <div class="col-md-5">
                        $images_carousel
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h3 class="card-title text-dark">$product->name</h3>
                            <span class="text-dark">Color: </span><span class="text-muted">$product->color_name</span>
                            $category                       
                            <h1 class="text-dark pd-price">$discount_price $price</h1>
                            <div class="row pd_add_to_cart_row">
                                <div class="col d-flex justify-content-end">
                                    <input type="number" class="form-control number-of-items-input" value="$start_value" min="1" 
                                        max="$product->amount" id="amount_to_add" 
                                        onchange="this.value = Math.max(Math.min(this.value, this.max),1)" $disabled_amount>
                                </div>
                                <div class="col d-flex justify-content-start">
                                    <button class="btn btn-outline-$button_color btn-lg pd_add_to_cart_button" $disabled_amount
                                        onclick="add_to_cart($product->cv_id, document.getElementById('amount_to_add').value)">$button_text</button>
                                </div>
                            </div>
                            <div class="text-primary pd_available_in_stock">
                                Available in stock: <span class="badge bg-{$amount_background}">$product->amount</span>
                            </div>
                            <div style="margin-top: 10px;" class="d-flex align-items-center justify-content-center">
                                <p style="font-size: 18px;" class="text-dark" title="{$free_delivery_text}" 
                                        data-bs-toggle="tooltip" data-bs-placement="bottom">
                                    <img src="/TechTronic/images/truck.svg" class="pd_truck_image">
                                    <span class="text-dark pd_free_delivery_text">Free delivery<span>
                                </p>
                            </div>    
                            <a href="/TechTronic/products.php?category_id=$product->category_id&product_name={$product->product_name_base}">
                                <button type="button" class="btn btn-lg btn-secondary show-variants-button">Show all variants</button>
                            </a>
                            $color_versions
                        </div>
                    </div>
                </div>
            </div>
            <div class="break"></div>
            $specs
product;

    }

    $conn->close();
