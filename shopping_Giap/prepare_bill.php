<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/cart.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</head>

<body>
    <?php
    require "config/config.php";
    require ROOT . "/include/function.php";
    spl_autoload_register("loadClass");
    session_start();

    function prepareBill()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST['payment'])) {
                $listProduct = $_SESSION['product_id'] ?? null;

                $quantity = array();
                if (is_array($listProduct)) {
                    foreach ($listProduct as $value) {
                        if (isset($_POST[$value])) {
                            $quantity[$value] = $_POST[$value];
                        }
                    }

                    $_SESSION['cart'] = $quantity;
                }
            }
        }

        $db = new DB();

        $bill = array();
        $totalItem = 0;
        $totalNoShip = 0;
        $total = 0;
        if (isset($_SESSION)) {

            $listCart = $_SESSION['cart'] ?? null;
            
            if ($listCart != null) {
                foreach ($listCart as $id => $quantity) {
                    $sql = "SELECT * from product where id = :id";
                    $arr = array(":id" => $id);
                    $productList = $db->select($sql, $arr);

                    $product = $productList[0];
                    $totalItem += $quantity;
                    $totalNoShip += $quantity * $product['price'];
                }

                $total = $totalNoShip + 5;
            }
        }

        $bill = array("totalItem" => $totalItem, "totalNoShip" => $totalNoShip, "total" => $total);

        return $bill;
    }
    ?>
    <div class="summary container col-4">
        <?php
        $bill = prepareBill();
        $totalItem = $bill['totalItem'];
        $totalNoShip = $bill['totalNoShip'];
        $total = $bill['total'];
        ?>
        <div class="text-center">
            <h1><b>Summary</b></h1>
        </div>
        <hr>
        <div class="row">
            <div class="col" style="padding-left:0;">Total item:
                <?php echo $totalItem; ?>
            </div>
            <div class="col text-right">&dollar;
                <?php echo $totalNoShip; ?>
            </div>
        </div>
        <form action="order.php" method="post">
            <p>Vận chuyển</p>
            <select>
                <option class="text-muted">Standard-Delivery- &dollar;5.00</option>
                <option class="text-muted">Fast-Delivery- &dollar;10.00</option>

            </select>
            <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                <div class="col">Tổng tiền</div>
                <div class="col text-right">&dollar;
                    <?php echo $total; ?>
                </div>
            </div>
            <input type="hidden" value="<?php echo $total; ?>" name="total">
            <button type="submit" class="btn" name="btn-order">ĐẶT HÀNG</button>
        </form>
    </div>
</body>

</html>