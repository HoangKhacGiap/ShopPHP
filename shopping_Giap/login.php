<?php
require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");
session_start();

if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        body {
            padding: 50px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 50px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .form-group {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        $db = new Db();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST['login'])) {

                $email = $_POST['email'];
                $password = $_POST['password'];

                $sql = 'select * from user where email = :email';
                $arr = array(":email" => $email);

                $userList = $db->select($sql, $arr);

                if (count($userList) > 0) {
                    $user = $userList[0];
                    $md5 = md5($password);

                    if ($md5 == $user['password']) {
                        session_start();
                        $_SESSION["user"] = $email;
                        $_SESSION["role"] = $user["role_id"];
                        //===========================check quyền===========================
                        if ($user["role_id"] == 1) {
                            header("Location: test_admin.php");
                        } else {
                            header("Location: index.php");
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Mật khẩu của bạn không chính xác</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Tài khoản của bạn không chính xác</div>";
                }


            }
        }

        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <p>Bạn chưa có tài khoản ? <a href="registration.php">Đăng ký ngay đây nè</a></p>
        </div>
    </div>
</body>

</html>