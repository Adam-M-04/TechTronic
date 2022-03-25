<?php
    session_start();
    if(!isset($_SESSION["admin_id"])) header("location: /TechTronic/forbidden.html");

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/get_feature_name_ID.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    if(!isset($_POST['id']))
    {
        echo "ID not specified";
        exit();
    }

    $id = $_POST['id'];

    if(!(isset($_POST["product_name_base"]) and isset($_POST["product_name_version"]) and isset($_POST["producer"]) and isset($_POST["category_id"])
         and isset($_POST["feature_1_val"]) and isset($_POST["feature_2_val"]) and isset($_POST["feature_3_val"]) and isset($_POST["warranty"])))
    {
        header("location: /TechTronic/admin/product_view/{$id}/error/");
        exit();
    }

    $conn->obj->begin_transaction();
    $conn->obj->autocommit(false);

    $base_name = htmlentities($_POST["product_name_base"]);
    $version_name = htmlentities($_POST["product_name_version"]);
    $producer = get_producer_ID(htmlentities($_POST["producer"]), $conn);
    $category_id = intval($_POST["category_id"]);
    $feature_1 = get_feature_value_ID(htmlentities($_POST["feature_1_val"]), $conn);
    $feature_2 = get_feature_value_ID(htmlentities($_POST["feature_2_val"]), $conn);
    $feature_3 = get_feature_value_ID(htmlentities($_POST["feature_3_val"]), $conn);
    $warranty = intval($_POST["warranty"]);

    if(!($base_name and $producer and $category_id and $feature_1 and $feature_2 and $feature_3))
    {
        header("location: /TechTronic/admin/product_view/{$id}/error/");
        exit();
    }

    if($id == 0)
    {
        if ($conn->query("INSERT INTO products
                (producer_id, category_id, product_name_base, product_name_version, warranty, feature_1_val, feature_2_val, feature_3_val)
                VALUES ($producer, $category_id, '$base_name', '$version_name', $warranty, $feature_1, $feature_2, $feature_3)"))
        {
            $insert_id = $conn->obj->insert_id;
            $conn->obj->commit();
            header("location: /TechTronic/admin/products/added/{$insert_id}/");
        }
        else
        {
            $conn->obj->rollback();
            header("location: /TechTronic/admin/product_view/0/error/");
        }
    }
    else
    {
        if ($conn->query("UPDATE products SET producer_id=$producer, category_id=$category_id,
                    product_name_base='$base_name', product_name_version='$version_name', warranty=$warranty,
                    feature_1_val=$feature_1, feature_2_val=$feature_2, feature_3_val=$feature_3
                    WHERE product_id = $id"))
        {
            $conn->obj->commit();
            header("location: /TechTronic/admin/product_view/{$id}/edited/");
        }
        else
        {
            $conn->obj->rollback();
            header("location: /TechTronic/admin/product_view/{$id}/error/");
        }
    }

