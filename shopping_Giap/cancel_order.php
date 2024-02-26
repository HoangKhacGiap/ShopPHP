<?php
require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");
$db = new Db();

if (isset($_GET)) {
    $orderId = $_GET['id'];

    $sql = 'UPDATE orders set status = "cancel" where id =:id';
    $arr = array(':id' => $orderId);

    $result = $db->update($sql, $arr);

    echo '<h1>Huỷ đơn đặt hàng thành công</h1>';
    echo '<button style="padding: 5px 0px;  ">
            <a style="text-decoration: none" href="history.php">Nhấp vào đây để quay lại</a>
            </button>';
}
