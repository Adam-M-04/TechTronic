<?php
    function echo_product(object $product): void
    {
        $price = $product->min_price ? "FROM $".$product->min_price : "UNAVAILABLE";
        echo <<< product
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="ms-2 me-auto">
                  <div class="fw-bold product-title">{$product->product_name_base} {$product->product_name_version}</div>
                  <span class="product-category">{$product->category_name}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="product-price text-primary">{$price}</span>
                    <a href="/TechTronic/admin/product_view/{$product->product_id}/" class="no-underline">
                        <button class="btn btn-lg btn-outline-success button-width">Edit</button>
                    </a>
                    <button class="btn btn-lg btn-outline-danger delete-button button-width" data-bs-toggle="modal" data-bs-target="#confirm_delete" 
                         onmousedown="delete_product_click('{$product->product_name_base} {$product->product_name_version}', {$product->product_id})">Delete</button>
                </div>
              </li>
        product;

    }

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $min_price = "(SELECT MIN(price) FROM color_versions WHERE color_versions.product_id = products.product_id) as min_price";

    $query = "SELECT *, $min_price FROM products JOIN categories USING (category_id) ORDER BY product_name_base";

    echo '<div class="container"><ol class="list-group">';
    echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="ms-2 me-auto">
                  <div class="fw-bold product-title">Add new</div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <a href="/TechTronic/admin/product_view/0/" class="no-underline">
                        <button class="btn btn-lg btn-outline-success button-width">Add</button>
                    </a>
                </div>
              </li>';
    if($products = $conn->get_data($query))
    {
        foreach ($products as $product) echo_product($product);
    }
    echo '</ol></div>';

    echo '<div class="modal fade" id="confirm_delete" tabindex="-1" aria-labelledby="confirm_delete" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Are you sure you want to delete "<span id="deleted_product_name"></span>"</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-lg w-50" data-bs-dismiss="modal" style="margin: 5px 5px 5px -5px;">Cancel</button>
                        <a href="/TechTronic/scripts/delete_category.php?id=" class="no-underline w-50" id="delete_category_link">
                            <button type="button" class="btn btn-danger btn-lg w-100" style="margin: 5px;">Delete</button>
                        </a>
                      </div>
                    </div>
                  </div>
              </div>
              
          <script>
            function delete_product_click(name, id)
            {
                document.getElementById("deleted_product_name").innerText = name;
                document.getElementById("delete_category_link").href = "/TechTronic/scripts/delete_product.php?id="+id;
            }
          </script>
    ';

    $conn->close();