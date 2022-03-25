<?php
    function echo_category($id, $path, $name): void
    {
        echo <<< category
            <a href="/TechTronic/categories/$name&$id/" style="text-decoration: none;">
                <div class="card category_card shadow-lg">
                      <img src="/TechTronic/images/category_images/$path" class="card-img-top category_image" alt="category image">
                      <div class="card-body">
                            <h5 class="card-title text-dark" style="text-transform: uppercase">$name</h5>
                      </div>
                </div>
            </a>
category;
    }

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    if($categories = $conn->get_data("SELECT * FROM categories ORDER BY category_name"))
    {
        echo_category(-1, "all.png", "All products");
        foreach ($categories as $category) echo_category($category->category_id, $category->image_path, $category->category_name);
    }
    else
    {
        echo "<script>window.location.href = 'products.php'</script>";
    }

    $conn->close();
