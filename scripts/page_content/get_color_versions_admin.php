<?php
    if($_GET['id'] > 0)
    {
        echo "<br><br><h2 class='display-2 text-light text-center'>Color versions</h2>";
        $color_versions = $conn->get_data("SELECT * FROM color_versions JOIN colors USING (color_id) WHERE product_id = ".$_GET['id']);
        $index = 0;
        foreach ($color_versions as $color_version)
        {
            echo "<div class='container bg-white color-version-container'>
                    <div class='row d-flex justify-content-center images-row'>
                        <script>load_product_images({$index}, $color_version->cv_id)</script>
                    </div>
                    <form class='w-100' method='post' action='/TechTronic/scripts/edit_color_version.php' id='edit_form_{$color_version->cv_id}'>
                    <input type='hidden' name='cv_id' value='{$color_version->cv_id}'>
                    <input type='hidden' name='product_id' value='{$color_version->product_id}'>
                    <div class='row'>
                        <div class='col-3'>
                            <label class='form-label h3'>Color</label>
                            <input type='text' class='form-control form-control-lg' value='{$color_version->color_name}'
                                list='colors_datalist' name='color'>
                        </div>
                        <div class='col-3'>
                            <label class='form-label h3'>Amount</label>
                            <input type='number' class='form-control form-control-lg' min='0' max='99999' step='1' 
                                value='{$color_version->amount}' name='amount'>
                        </div>
                        <div class='col-3'>
                            <label class='form-label h3'>Price <strong class='text-primary'>$</strong></label>
                            <input type='number' class='form-control form-control-lg' min='0.01' step='0.01' 
                                value='{$color_version->price}' name='price' onchange='this.value = parseFloat(this.value).toFixed(2);'>
                        </div>
                        <div class='col-3'>
                            <label class='form-label h3'>Discount price <strong class='text-primary'>$</strong></label>
                            <input type='number' class='form-control form-control-lg' min='0.01' step='0.01'
                                value='{$color_version->discount_price}' name='discount_price' onchange='this.value = parseFloat(this.value).toFixed(2);'>
                        </div>
                    </div>
                    </form>
                    <div class='row buttons-row'>
                        <div class='col-6'>                                   
                            <button class='btn btn-lg btn-outline-success w-100' 
                                onclick='edit_color_version({$color_version->cv_id})'>Edit</button>
                        </div>
                        <div class='col-6'>
                            <input type='hidden' name='cv_id' value='{$color_version->cv_id}'>
                            <input type='hidden' name='product_id' value='{$color_version->product_id}'>
                            <button class='btn btn-lg btn-outline-danger w-100' data-bs-target='#confirm_delete' data-bs-toggle='modal' 
                                    onclick='delete_product_click(`{$color_version->cv_id}`, {$color_version->product_id})'>
                                Delete
                            </button>
                        </div>
                    </div>
                  </div>";
            ++$index;
        }

        // Add new
        echo "<form method='post' action='/TechTronic/scripts/add_color_version.php' id='add_cv'>
                  <input type='hidden' name='id' value='{$_GET['id']}'>
                  <div class='container bg-white color-version-container'>
                    <div class='row'>
                        <div class='col-3'>
                            <label class='form-label h3'>Color</label>
                            <input type='text' class='form-control form-control-lg' list='colors_datalist' name='color' required>
                        </div>
                        <div class='col-3'>
                            <label class='form-label h3'>Amount</label>
                            <input type='number' class='form-control form-control-lg' min='0' max='99999' step='1' name='amount' required>
                        </div>
                        <div class='col-3'>
                            <label class='form-label h3'>Price <strong class='text-primary'>$</strong></label>
                            <input type='number' class='form-control form-control-lg' min='0.01' step='0.01' name='price' required
                                onchange='this.value = parseFloat(this.value).toFixed(2);'>
                        </div>
                        <div class='col-3'>
                            <label class='form-label h3'>Discount price <strong class='text-primary'>$</strong></label>
                            <input type='number' class='form-control form-control-lg' min='0.01' step='0.01'
                                name='discount_price' onchange='this.value = parseFloat(this.value).toFixed(2);'>
                        </div>
                        </div>
                        <div class='row buttons-row'>
                            <div class='col-12'>
                                <button class='btn btn-lg btn-success w-100' onclick='add_color_version()'>Add</button>
                            </div>
                        </div> 
                        
                  </div></form>";

        # Colors datalist
        $all_colors = $conn->get_data("SELECT color_name FROM colors ORDER BY color_name");
        echo "<datalist id='colors_datalist'>";
        foreach ($all_colors as $color)
        {
            echo "<option value='{$color->color_name}'>";
        }
        echo "</datalist>";

        echo '<div class="modal fade" id="confirm_delete" tabindex="-1" aria-labelledby="confirm_delete" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Are you sure you want to delete color version?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form method="post" action="/TechTronic/scripts/delete_color_version.php">
                              <div class="modal-body d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary btn-lg w-50" data-bs-dismiss="modal" style="margin: 5px 5px 5px -5px;">Cancel</button>
                                <button type="submit" class="btn btn-danger btn-lg w-100" style="margin: 5px;">Delete</button>
                                <input type="hidden" id="cv_id_input" name="cv_id" value="-1">
                                <input type="hidden" id="product_id_input" name="product_id" value="-1">
                              </div>
                           </form>
                        </div>
                      </div>
                  </div>
                  
                <script>
                    function delete_product_click(cv_id, product_id)
                    {
                        document.getElementById("cv_id_input").value = cv_id
                        document.getElementById("product_id_input").value = product_id
                    }
                    
                    get_images_gallery()
                </script>
                ';
    }

