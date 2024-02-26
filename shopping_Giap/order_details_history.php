<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/style1.css" rel="stylesheet" />
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Nhà sản xuất</th>
                    <th>Loại hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require "config/config.php";
                require ROOT . "/include/function.php";
                spl_autoload_register("loadClass");

                $db = new Db();

                if (isset($_GET)) {
                    $orderId = $_GET['id'];
                    $sql = 'SELECT order_details.id ,product.name, order_details.count, manufacturer.name as "manufacturer" , categories.name as "categories" 
                    from order_details 
                    join product on order_details.product_id = product.id 
                    join manufacturer on manufacturer.id = product.manufacturer_id
                    join categories on categories.id = product.categories_id
                    where order_details.orders_id =:ordersId';

                    $arr = array(":ordersId" => $orderId);

                    $orderDetailsList = $db->select($sql, $arr);
                    $count = 1;
                    foreach ($orderDetailsList as $orderDetails) {
                        echo '<tr>';
                        echo '<td>' . $count++ . '</td>';
                        echo '<td>' . $orderDetails['name'] . '</td>';
                        echo '<td>' . $orderDetails['count'] . '</td>';
                        echo '<td>' . $orderDetails['manufacturer'] . '</td>';
                        echo '<td>' . $orderDetails['categories'] . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>