<?php
require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");
session_start();

$obj = new Product();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="css/cart.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <style>
        .btn-submit {
            border: 1px solid;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col " >
                            <h4><b>Shopping Cart</b></h4>
                        </div>
                    </div>
                </div>
                <form action="prepare_bill.php" method="POST">
                    <?php
                    $obj->productCart();
                    ?>
                    <div class="back-to-shop d-flex justify-content-between">
                        <a href="index.php">
                            <span class="btn btn-primary">Back to shop</span>
                            <?php

                            ?>
                        </a>
                        <button class="btn col-3 btn-submit" name="payment">Tính tiền</button>
                        <div></div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</body>
<?php
//============================kiểm tra giỏ hàng null và xóa sản phẩm nếu đặt thành công check từ session
if (isset($_GET)) {
    if ($_GET != null) {

        $id = $_GET['id'];
        unset($_SESSION['cart'][$id]);

        $search = array_search($id, $_SESSION['product_id']);
        unset($_SESSION['product_id'][$search]);
    }
}
?>

</html>