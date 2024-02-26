<?php
require "config/config.php";
require ROOT . "/include/function.php";

spl_autoload_register("loadClass");
session_start();

if (isset($_SESSION["user"])) {

    unset($_SESSION["user"]);
    unset($_SESSION["role"]);
    header("Location: index.php");
}
else {
    echo '<h1>Bạn chưa đăng nhập<h1>';
    echo '<br><h3>Hãy thực hiện đăng nhập và quay lại<h3>';
    echo '<br><a href = "login.php"> Nhấp vào đây để đăng nhập</a>';
}
?>