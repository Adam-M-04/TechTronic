<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/admin");

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/get_feature_name_ID.php");
    $conn = new Connection();

    function DisplayError(string $message = "An error occurred"): void
    {
        echo "<div class='container-sm' style='font-size: 20px;'>
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>$message
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                 </div></div>";
    }

    if(isset($_POST['category_name']) and isset($_POST['feature_name_1']) and isset($_POST['feature_name_2']) and isset($_POST['feature_name_3']))
    {
        $id = intval($_GET['id']);
        $error = false;
        $upload_image = true;

        // Image
        if(isset($_FILES['category_image'])){
            if($_FILES['category_image']["error"] == 0)
            {
                $image = $_FILES['category_image'];
                $extension = explode('.',$image['name']);
                $extension = strtolower(end($extension));
                if(in_array($extension, ['png', 'jpg', 'jpeg']))
                {
                    if($image['size'] > 1048576) {
                        $error = "Max file size is 1MB";
                    }
                }
                else
                {
                    $error = "Wrong file extension";
                }
            }
            else
            {
                if($id == 0) $error = "Image not selected";
                else $upload_image = false;
            }
        }

        if($error)
        {
           DisplayError($error);
        }
        else
        {
            $conn->obj->begin_transaction();
            $conn->obj->autocommit(false);

            $category_name = htmlentities($_POST['category_name']);
            $feature_1 = get_feature_name_ID($_POST['feature_name_1'], $conn);
            $feature_2 = get_feature_name_ID($_POST['feature_name_2'], $conn);
            $feature_3 = get_feature_name_ID($_POST['feature_name_3'], $conn);

            if($id == 0)
            {
                $query = $conn->obj->prepare("INSERT INTO categories (category_name, feature_1_name, feature_2_name, feature_3_name) 
                VALUES (?, $feature_1, $feature_2, $feature_3)");
                $query->bind_param('s', $category_name);
                $response = $query->execute();
            }
            else
            {
                $query = $conn->obj->prepare("UPDATE categories SET category_name = ?, feature_1_name = $feature_1, 
                      feature_2_name = $feature_2, feature_3_name = $feature_3 WHERE category_id = $id");
                $query->bind_param('s', $category_name);
                $response = $query->execute();

                if(!$upload_image)
                {
                    if($response)
                    {
                        $conn->obj->commit();
                        header("location: /TechTronic/admin/categories/m/success/");
                        exit();
                    }
                }
            }

            if($response)
            {
                $category_id = $id == 0 ? $query->insert_id : $id;

                $new_name = $category_id.".".$extension;
                $new_path = "../images/category_images/".$new_name;
                if(file_exists($new_path)) unlink($new_path);
                move_uploaded_file($image['tmp_name'], $new_path);

                if($conn->query("UPDATE categories SET image_path = '$new_name' WHERE category_id = $category_id"))
                {
                    $conn->obj->commit();
                    header("location: /TechTronic/admin/categories/".($id==0?"a":"m")."/success/");
                }
                else
                {
                    $conn->obj->rollback();
                    DisplayError();
                }
            }
            else
            {
                $conn->obj->rollback();
                DisplayError();
            }

            $query->close();
        }

    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/png" href="/TechTronic/images/favicon.ico"/>
        <title>Categories - admin</title>
        <link rel="stylesheet" href="/TechTronic/styles/main.css">
        <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
        <link rel="stylesheet" href="/TechTronic/styles/admin-header.css">
        <link rel="stylesheet" href="/TechTronic/styles/admin-category_view.css">
        <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    <?php include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/admin-menu.php"); ?>
    <h1 class="display-1 text-center text-light" style="margin-bottom: 20px;">
        <?php
            if(!isset($_GET['id']))
            {
                echo "No ID specified";
                exit();
            }

            if($_GET['id'] == "0")
            {
                echo "Add new category";
                $category = false;
            }
            else
            {
                $query = "SELECT *, 
                    (SELECT specification_name FROM specification_names WHERE sn_id = feature_1_name) as feature_1,
                    (SELECT specification_name FROM specification_names WHERE sn_id = feature_2_name) as feature_2,
                    (SELECT specification_name FROM specification_names WHERE sn_id = feature_3_name) as feature_3 
                    FROM categories WHERE category_id = ".((int)$_GET['id']);
                $category = $conn->get_data($query);

                if($category)
                {
                    $category = $category[0];
                    echo "Edit category - $category->category_name";
                }
                else
                {
                    echo "Category not found";
                    exit();
                }
            }
        ?>
    </h1>
    <form method="post" action="#" enctype="multipart/form-data">
        <div class="container bg-white d-flex flex-wrap">
            <div class="col-4 position-relative" id="img_selector">
                <?php
                    if($category) echo "<img id='image_preview' class='category_image' src='/TechTronic/images/category_images/$category->image_path'>";
                    else echo "<img id='image_preview' class='add_image' src='/TechTronic/images/plus-square.svg'>";
                ?>
                <button type="button" class="btn btn-lg btn-primary" id="image_button">
                    <label for="image_input" id="button_label">Select image</label>
                </button>
                <input type="file" name="category_image" style="display: none;" id="image_input"
                       accept=".jpg, .jpeg, .png" onchange="show_thumbnail()">
            </div>
            <div class="col-8 form-data">
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-3 col-form-label fw-bold">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-lg" name="category_name" required
                               value="<?php if($category) echo $category->category_name; ?>" maxlength="100">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-12 col-form-label fw-bold">
                        Main features of this category
                    </label>
                </div>
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Feature name 1</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-lg" name="feature_name_1" list="specification_names"
                               value="<?php if($category) echo $category->feature_1; ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Feature name 2</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-lg" name="feature_name_2" list="specification_names"
                               value="<?php if($category) echo $category->feature_2; ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-3 col-form-label">Feature name 3</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-lg" name="feature_name_3" list="specification_names"
                               value="<?php if($category) echo $category->feature_3; ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <button type="submit" class="btn btn-lg btn-outline-success w-100">Confirm</button>
                </div>

                <?php
                    $datalist = $conn->get_data("SELECT specification_name FROM specification_names");
                    echo "<datalist id='specification_names'>";
                    foreach ($datalist as $item)
                    {
                        echo "<option>$item->specification_name</option>";
                    }
                    echo "</datalist>";

                    $conn->close();
                ?>
            </div>
        </div>
    </form>

    <script>
        function show_thumbnail()
        {
            const file = document.getElementById('image_input').files[0];
            const reader = new FileReader();
            reader.onload = (function(aImg)
            {
                return function(e) { aImg.src = e.target.result;aImg.className = "category_image" };
            })(document.getElementById('image_preview'));

            reader.readAsDataURL(file);
        }
    </script>

    </body>
</html>