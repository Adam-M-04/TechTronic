<?php
    session_start();

    $email = htmlentities($_POST["email"]);
    $password = htmlentities($_POST["password"]);

    include_once ($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
    $conn = new Connection();

    $query = $conn->obj->prepare("SELECT * FROM users WHERE email = ?");

    $query->bind_param("s", $email);

    $query->execute();

    $result = $query->get_result();
    if($result)
    {
        $user = $result->fetch_object();
        if(password_verify($password, $user->password_hash))
        {
            $_SESSION["user_id"] = $user->user_id;
            $_SESSION["user_name"] = $user->first_name." ".$user->last_name;
            echo "1";
        }
    }

    $query->close();
    $conn->close();