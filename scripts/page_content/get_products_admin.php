<?php
    function echo_product(object $product): void
    {
        $price = $product->min_price ? "FROM $".$product->min_price : "UNAVAILABLE";
        $amount = $product->amount ?? "0";
        echo <<< category
                <div class="container shadow-lg bg-light product-cell" data-bs-toggle="collapse" data-bs-target="#product_data_{$product->product_id}" aria-expanded="false">
                    <div class="d-flex justify-content-between">
                        <h3 class="text-dark product-title">{$product->product_name_base} {$product->product_name_version}&nbsp
                            <span class="text-secondary">({$product->category_name})</span></h3><br>
                        <div class="d-flex justify-content-between">
                            <h4 class="text-primary d-flex align-items-center" style="margin-bottom: 0px;">{$price}</h4>
                            <a href="/TechTronic/admin/product_view/{$product->product_id}/" class="no-underline">
                                <button class="btn btn-lg btn-outline-primary button-width">Edit</button>
                            </a>
                            <button class="btn btn-lg btn-outline-danger delete-button button-width" data-bs-toggle="modal" data-bs-target="#confirm_delete"
                                 onmousedown="delete_product_click('{$product->product_name_base} {$product->product_name_version}', {$product->product_id})">Delete</button>
                        </div>
                    </div>
                    <div id="product_data_{$product->product_id}" class="collapse" >
                        <table class="table table-hover text-center specification_table">
                          <tbody>
                            <tr>
                              <td>Total amount</td>
                              <td>{$amount}</td>
                            </tr>
                            <tr>
                              <td>{$product->fn1}</td>
                              <td>{$product->fv1}</td>
                            </tr>
                            <tr>
                              <td>{$product->fn2}</td>
                              <td>{$product->fv2}</td>
                            </tr>
                            <tr>
                              <td>{$product->fn3}</td>
                              <td>{$product->fv3}</td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
            category;
    }

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $specification_names_query  = "(SELECT specification_name FROM specification_names WHERE sn_id = categories.feature_1_name) as fn1, ";
    $specification_names_query .= "(SELECT specification_name FROM specification_names WHERE sn_id = categories.feature_2_name) as fn2, ";
    $specification_names_query .= "(SELECT specification_name FROM specification_names WHERE sn_id = categories.feature_3_name) as fn3";

    $specification_values_query  = "(SELECT specification_value FROM specification_values WHERE sv_id = products.feature_1_val) as fv1, ";
    $specification_values_query .= "(SELECT specification_value FROM specification_values WHERE sv_id = products.feature_2_val) as fv2, ";
    $specification_values_query .= "(SELECT specification_value FROM specification_values WHERE sv_id = products.feature_3_val) as fv3";

    $min_price = "(SELECT MIN(price) FROM color_versions WHERE color_versions.product_id = products.product_id) as min_price";
    $amount = "(SELECT SUM(amount) FROM color_versions WHERE color_versions.product_id = products.product_id) as amount";

    $query = "SELECT *, $specification_names_query, $specification_values_query, $min_price, $amount
                FROM products JOIN categories USING (category_id) ORDER BY product_name_base";

    echo '<div class="container shadow-lg bg-light product-cell d-flex justify-content-between">
                    <h3 class="text-dark product-title">Add new</h3><br>
                    <a href="/TechTronic/admin/product_view/0/" class="no-underline">
                        <button class="btn btn-lg btn-outline-success button-width">Add</button>
                    </a>
                </div>';
    if($products = $conn->get_data($query))
    {
        foreach ($products as $product) echo_product($product);
    }

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