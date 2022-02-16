<?php
    $email = htmlentities($_POST["email"]);

    include_once ("sql_connection.php");
    $conn = new Connection();

    $query = $conn->obj->prepare("SELECT COUNT(user_id) as number FROM users WHERE email = ?");

    $query->bind_param("s", $email);

    $query->execute();

    $result = $query->get_result();
    if($result)
    {
        if($result->fetch_object()->number != 0) echo "false";
        else echo "true";
    }
    else echo "true";

    $query->close();
    $conn->close();
