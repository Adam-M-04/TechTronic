<ul class='list-group'>
<?php
    if(session_status() != PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["admin_id"])) exit();
    if(!isset($_GET["id"])) {echo "No ID specified"; exit();}

    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $s_query = "SELECT * FROM product_specification JOIN specification_names USING (sn_id) JOIN specification_values USING (sv_id)
                        WHERE product_id = ".(intval($_GET['id']));
    $specification = $conn->get_data($s_query);
    foreach ($specification as $data)
    {
        echo "<li class='list-group-item d-flex'>
                <div class='w-25 s_cell'>
                    <input type='text' class='form-control form-control-lg fw-bold' value='{$data->specification_name}' 
                        id='sn_{$data->id}' list='features_names_datalist'>
                </div>
                <div class='w-25 s_cell'>
                    <input type='text' class='form-control form-control-lg' value='{$data->specification_value}' 
                        id='sv_{$data->id}' list='features_datalist'>
                </div>
                <div class='w-25 s_cell'>
                    <button class='btn btn-lg btn-outline-success w-100' onclick='update_specification({$data->id})'>Update</button>
                </div>
                <div class='w-25 s_cell'>
                    <button class='btn btn-lg btn-outline-danger w-100' onclick='delete_specification({$data->id})'>Delete</button>
                </div>
              </li>";
    }
    echo "<li class='list-group-item d-flex'>
            <div class='w-25 s_cell'>
                <input type='text' class='form-control form-control-lg fw-bold' list='features_names_datalist' id='sn_new'>
            </div>
            <div class='w-25 s_cell'>
                <input type='text' class='form-control form-control-lg' list='features_datalist' id='sv_new'>
            </div>
            <div class='w-50 s_cell'>
                <button class='btn btn-lg btn-outline-success w-100' onclick='add_specification({$_GET['id']})'>Add</button>
            </div>
          </li></ul>";