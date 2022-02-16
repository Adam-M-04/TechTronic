<?php

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();
    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/check_amount_in_cart.php");

    $products = $conn->get_data("SELECT c.cart_item_id, c.cv_id, c.amount as selected_amount ,cv.*, 
            CONCAT(p.product_name_base,' ',p.product_name_version) as name, pi.image_path  FROM cart c
        JOIN color_versions cv USING (cv_id)
        JOIN products p USING (product_id)
        LEFT JOIN product_images pi on cv.main_image_id = pi.image_id
        WHERE user_id = {$_SESSION['user_id']}");

    if($products == [])
    {
        echo "<a href='/TechTronic/categories/'><button class='btn btn-lg btn-primary'>Browse products</button></a>
            <script>document.getElementById('cart_title').innerText = 'Your shopping cart is empty'</script>";
    }
    else
    {
        $items_count = 0;
        $total_value = 0;

        foreach ($products as $product)
        {
            $items_count += (float)$product->selected_amount;
            $total_value += (float)$product->selected_amount * (float)$product->price;

            $price = number_format($product->price,2);
            $img_src = isset($product->image_path) ? "product_images/$product->image_path" : "card-image.png";
            if($product->amount == 0) $options = "<h3 style='margin-right: 20px;' class='text-danger'>Sold out</h3>";
            else $options = "<h3 class='text-primary'>$$price</h3>
                             <input type=\"number\" class=\"form-control form-control-lg amount_of_product\" 
                                  value=\"$product->selected_amount\" min=\"1\" max=\"$product->amount\" 
                                  onblur='this.value = Math.max(Math.min(this.value, this.max),1);update_amount_in_cart($product->cv_id, this.value)'>
                             ";
            $darker = $product->amount == 0 ? " style=\"filter: brightness(0.6)\"" : "";

            echo <<< product
                <div class="card mb-3 text-dark product-in-cart"$darker style="border-radius: 10px;">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img src="/TechTronic/images/$img_src" class="img-fluid product-in-cart-img" alt="product image">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body row g-0 product-in-cart-body">
                                <div class="col-md-9 d-flex justify-content-start align-items-center">
                                    <a href="/TechTronic/products/$product->cv_id/" style="text-decoration: none;">
                                        <h3 class="card-title text-dark">$product->name</h3>
                                    </a>
                                </div>
                                <div class="col-md-3 product-in-cart-options">
                                    $options
                                    <button type="button" class="btn-close btn-lg remove-product-button" 
                                        aria-label="Close" onclick="remove_from_cart($product->cv_id)"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
product;

        }

        $total_value = number_format($total_value, 2);
        echo <<< summary
            <div class="container cart-summary bg-light text-dark">
                <div class="row">
                    <div class="col-6" style="text-align: left; padding-left: 40px;"><strong>Total:</strong> $$total_value</div>
                    <div class="col-6" style="text-align: right; padding-right: 40px;">
                        <span class="text-muted" style="font-size: 22px; margin-right: 20px;">($items_count items)</span> 
                        <a href="/TechTronic/order_details.php">
                            <button class="btn btn-lg btn-outline-success">Continue</button>
                        </a>
                    </div>
                </div>
            </div>
summary;


    }
    $conn->close();
