<?php
    $product_id = $_GET["id"] ?? -1;

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/product_view_components.php");

    $result = $conn->get_data(
        "SELECT 
                    cv.*,
                    p.product_id, p.producer_id, CONCAT(p.product_name_base, ' ', p.product_name_version) as name, p.warranty,
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

    if(count($result) == 0)
    {
        echo "<h2>Product not found<h2>";
    }
    else
    {
        $product = $result[0];
        $price = number_format(intval($product->price)). "<sup style='color: #676767; font-size: 24px;'>" .(substr((string)$product->price, -2))."</sup>";
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

        echo <<< product
            <script id="title_change">
                document.title = "$product->name - TechTronic"
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
                            <h1 class="text-dark" style="margin-top: 40px;">$$price</h1>
                            <div class="row" style="margin-top: 30px; flex-wrap: nowrap;">
                                <div class="col" style="display: flex;justify-content: right;">
                                    <input type="number" class="form-control number-of-items-input" value="1" min="1" 
                                        max="$product->amount" id="amount_to_add" 
                                        onchange="this.value = Math.max(Math.min(this.value, this.max),1)">
                                </div>
                                <div class="col" style="display: flex;justify-content: left;">
                                    <button class="btn btn-outline-success btn-lg" style="width: 140px;" 
                                        onclick="add_to_cart($product->cv_id, document.getElementById('amount_to_add').value)">Add to cart</button>
                                </div>
                            </div>
                            <div style="margin-top: 15px; font-size: 18px;" class="text-primary">
                                Available in stock: <span class="badge bg-{$amount_background}">$product->amount</span>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: center;margin-top: 10px;">
                                <p style="font-size: 18px;" class="text-dark" title="Free shipping when ordering an item
                                        or items valued at $100 or more" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                    <img src="/TechTronic/images/truck.svg" style="width: 25px; height: 25px;">
                                    <span class="text-dark" style="margin: 0 8px 0 8px; font-weight: 500;">Free delivery<span>
                                </p>
                            </div>    
                            <a href="/TechTronic/products.php?category_id=$product->category_id&name=All variants&product_id=$product->product_id">
                            <a href="/TechTronic/products.php?category_id=$product->category_id&name=All variants&product_id=$product->product_id">
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
