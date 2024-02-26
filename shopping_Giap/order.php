<?php
require "config/config.php";
require ROOT . "/include/function.php";

spl_autoload_register("loadClass");
session_start();
$db = new Db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['btn-order'])) {
        $listCart = $_SESSION['cart'] ?? null;
        $total = $_POST['total'];

        $email = $_SESSION['user'] ?? null;
        
        if($listCart == null) {
            echo '<h1>Giỏ hàng của bạn chưa có gì<h1>';
            echo '<h3>Hãy quay lại mua sắm<h3>';
            echo '<br><a href = "cart.php"> Về giỏ hàng</a>';
            exit();
        }

        if ($email == null) {
            echo '<h1>Bạn chưa đăng nhập<h1>';
            echo '<br><h3>Hãy thực hiện đăng nhập và quay lại<h3>';
            echo '<br><a href = "login.php"> Nhấp vào đây để đăng nhập</a>';
            exit();
        }

        $sql = "SELECT * from user where email = :email";
        $arr = array(":email" => $email);

        $userList = $db->select($sql, $arr);
        $user = $userList[0];
        $status = 'created';

        $sql = "INSERT into orders(total, status, user_id) values (:total, :status, :userId)";
        $arr = array(":total"=>$total,":status"=>$status, ":userId"=>$user['id']);
        $row = $db->insert($sql,$arr);

        if($row <= 0) {
            echo '<h1>Tạo đơn hàng thất bại. Xin hãy thử lại<h1>';
            echo '<br><a href = "cart.php"> Về giỏ hàng</a>';
            exit();
        } 
        else {
            $newIdOrder = $db->getNewIDInsert();
            foreach ($listCart as $productId => $quantity) {
                $sql = "INSERT into order_details(count, orders_id, product_id) values (:count, :ordersId, :productId)";
                $arr = array(":count"=>$quantity, ":ordersId"=>$newIdOrder,":productId"=>$productId);
                $row = $db->insert($sql, $arr);

                if($row <= 0) {
                    echo '<h1>Tạo đơn hàng thất bại. Xin hãy thử lại<h1>';
                    echo '<br><a href = "cart.php"> Về giỏ hàng</a>';
                    exit();
                }
            }
        }

        unset($_SESSION['cart']);
        unset($_SESSION['product_id']);

        echo '<h1>Tạo đơn hàng thành công<h1>';
        echo '<h2>Hân hạnh vì được phục vụ quý khách<h2>';
        echo '<br><a href = "index.php"> Về trang chủ</a>';
    }
}

?>