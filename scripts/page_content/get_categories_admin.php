<?php
    function echo_category($id, $path, $name): void
    {
        echo <<< category
            <div class="card category_card shadow-lg">
                  <img src="/TechTronic/images/category_images/$path" class="card-img-top category_image" alt="category image">
                  <div class="card-body">
                        <h5 class="card-title text-dark" style="text-transform: uppercase">$name</h5><br>
                        <a href="/TechTronic/admin/category_view/$id/" class="no-underline">
                            <button class="btn btn-lg w-100 btn-outline-primary">Edit</button>
                        </a>
                        <button class="btn btn-lg w-100 btn-outline-danger delete-button" data-bs-toggle="modal" data-bs-target="#confirm_delete"
                             onmousedown="delete_category_click('$name', $id)">Delete</button>
                  </div>
            </div>
        category;
    }

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    echo '<div class="card category_card shadow-lg">
                  <img src="/TechTronic/images/plus-square.svg" class="card-img-top add_image" alt="category image">
                  <div class="card-body">
                        <h5 class="card-title text-dark" style="text-transform: uppercase">Add new</h5><br>
                        <a href="/TechTronic/admin/category_view/0/" class="no-underline">
                            <button class="btn btn-lg w-100 btn-outline-success" style="margin-top: 58px;">Add</button>
                        </a>
                  </div>
            </div>';
    if($categories = $conn->get_data("SELECT * FROM categories ORDER BY category_name"))
    {
        foreach ($categories as $category) echo_category($category->category_id, $category->image_path, $category->category_name);
    }

    echo '<div class="modal fade" id="confirm_delete" tabindex="-1" aria-labelledby="confirm_delete" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Are you sure you want to delete "<span id="deleted_category_name"></span>" category?</h5>
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
            function delete_category_click(name, id)
            {
                document.getElementById("deleted_category_name").innerText = name;
                document.getElementById("delete_category_link").href = "/TechTronic/scripts/delete_category.php?id="+id;
            }
          </script>
          ';

    $conn->close();