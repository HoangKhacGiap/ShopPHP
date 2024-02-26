<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    require "config/config.php";
    require ROOT . "/include/function.php";
    spl_autoload_register("loadClass");

    $db = new Db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['registration'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['confirm-password'];
        $name = $_POST['name'];
        $roleId = 2;
        $encrypted_password = md5($password);

        if($password != $password_confirm) {
            echo '<h1>Mật khẩu xác nhận không trùng khớp<h1>';
            echo '<a href="registration.php">Nhấp vào đây để về lại trang đăng ký</a>';
            exit();
        }


        $sql = 'SELECT count(*) from user where email=:email';
        $arr = array(":email"=>$email);
        $result = $db->select($sql, $arr)[0];

        if($result['count(*)'] != 0) {
            echo '<h1>Email đã tồn tại, vui lòng chọn email khác</h1>';
            echo '<a href="registration.php">Nhấp vào đây để về lại trang đăng ký</a>';
            exit();
        }

        $sql = 'INSERT INTO user (fullname, email, password, role_id) VALUES (:name, :email, :password, :roleId)';
        $arr = array(":name" => $name, ":email" => $email, ":password" => $encrypted_password, ":roleId" => $roleId);
        
        $row = $db->insert($sql, $arr);
        if ($row > 0) {
            echo '<h1>Đăng ký tài khoản thành công</h1><br>';
            echo '<a href="index.php">Nhấp vào đây để về trang chủ</a>';
            session_start();
            $_SESSION['user'] = $email;
        } else {
            echo '<h1>Tạo tài khoản thất bại, xin hãy thử lại</h1>';
            echo '<a href="registration.php">Nhấp vào đây để về lại trang đăng ký</a>';
        }
    }
}
    ?>
</body>
</html>