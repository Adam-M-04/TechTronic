<?php
    function go_back(string $err_code, object $conn): void
    {
        header("location: /TechTronic/settings/login/failure=$err_code");
        $conn->close();
        exit();
    }

    session_start();
    if(!isset($_SESSION['user_id'])){header("location: /TechTronic/forbidden.html");exit();}

    include_once ("sql_connection.php");
    $conn = new Connection();

    $password1 = htmlentities(
        preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $_POST["new_password"])
            ? $_POST["new_password"] : "");
    $password2 = htmlentities($_POST["confirm_password"]);

    if(strlen($password1) == 0) go_back(1, $conn, false);
    if($password1 != $password2) go_back(4, $conn, false);

    try {
        $password_hash = $conn->get_data("SELECT password_hash FROM users WHERE user_id = ".$_SESSION['user_id'])[0]->password_hash;
    }
    catch (Exception $e)
    {
        $password_hash = '';
    }
    $password = $_POST['password'] ?? '';
    if(!password_verify($password, $password_hash)) go_back(2, $conn);

    $email_query = $conn->obj->prepare('UPDATE users SET password_hash = ? WHERE user_id = '.$_SESSION['user_id']);
    if(!$email_query) go_back(0, $conn);

    $new_password_hash = password_hash($password1, PASSWORD_DEFAULT, ['cost' => 12]);
    $email_query->bind_param('s', $new_password_hash);
    $response = $email_query->execute();
    if(!$response) go_back(0, $conn);

    $email_query->close();
    $conn->close();
    header("location: /TechTronic/settings/login/success=p");
