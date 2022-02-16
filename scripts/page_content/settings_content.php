<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/page_content/settings_content_functions.php");

    $content_type = $_GET["c"] ?? "details";

    $active_btn = match ($content_type){
        "details" => 0,
        "address" => 1,
        "login" => 2,
        default => null
    };

    if(isset($active_btn)) echo "<script id='set-active-btn'>
            document.getElementsByClassName('btn-navigation')[$active_btn].classList.add('active')
            document.getElementById('set-active-btn').remove()
        </script>";

    include_once ($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    switch ($content_type)
    {
        case "address":
            echo message("address");
            echo address($conn);
            break;
        case "login":
            echo message("login");
            echo login($conn);
            break;
        default:
            echo message();
            echo details($conn);
    }
