<?php
    session_start();
    if(isset($_SESSION["user_id"])) header("location: /TechTronic/");
    if(isset($_SESSION["admin_id"])) header("location: /TechTronic/admin/dashboard/");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/TechTronic/images/logo_small.png"/>
    <title>Login - admin dashboard</title>
    <link rel="stylesheet" href="/TechTronic/styles/main.css">
    <link rel="stylesheet" href="/TechTronic/styles/body_background.css">
    <script src="/TechTronic/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="text-center text-white bg-dark">

    <?php
        if(isset($_POST['login']) and isset($_POST['password']))
        {
            include_once ($_SERVER['DOCUMENT_ROOT']."/TechTronic/scripts/sql_connection.php");
            $conn = new Connection();

            $login = htmlentities($_POST['login']);
            $query = $conn->obj->prepare("SELECT admin_id,password_hash FROM admin_login WHERE login = ?");
            $query->bind_param("s", $login);
            $query->execute();
            $result = $query->get_result();
            if($result)
            {
                if($admin = $result->fetch_object())
                {
                    if(password_verify($_POST['password'], $admin->password_hash))
                    {
                        $_SESSION["admin_id"] = $admin->admin_id;
                        header('location: /TechTronic/admin/dashboard/');
                        exit();
                    }
                }
            }
            echo '<div class="d-flex justify-content-center">
                    <div class="alert alert-danger" role="alert" style="width: 100%;max-width: 400px; font-size: 20px;">
                        Invalid login or password
                    </div>
                 </div>';
        }
    ?>

    <div id="content" class="d-flex justify-content-center">
        <form id="form" class="bg-light text-dark" method="post" action="#"
                style="width: 100%; max-width: 400px; padding: 40px; border-radius: 10px;">
            <h1 class="mb-3" id="header">Login as admin</h1>
            <div class="form-floating mb-3">
                <input type="text" class="form-control form-control-lg" name="login" id="login" placeholder=" " maxlength="100" required>
                <label for="login">Login</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder=" ">
                <label for="password">Password</label>
            </div>
            <input type="submit" class="btn btn-success btn-lg w-100" value="Login" id="submit_button">
        </form>
    </div>

</body>
</html>