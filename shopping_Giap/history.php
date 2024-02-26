<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng</title>

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
                    <th>Trạng thái</th>
                    <th>Tổng số tiền</th>
                    <th>Xem chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require "config/config.php";
                require ROOT . "/include/function.php";
                spl_autoload_register("loadClass");
                session_start();

                if (isset($_SESSION["user"])) {
                    $email = $_SESSION["user"];
                } else {
                    header("Location: login.php");
                }

                $db = new Db();

                $sql = "SELECT orders.id, orders.total, orders.status 
                from orders join user on orders.user_id = user.id
                where user.email  = :email";

                $arr = array(":email" => $email);

                $orderList = $db->select($sql, $arr);

                $count = 1;

                foreach ($orderList as $order) {
                    echo '<tr>';
                    echo '<td>' . $count++ . '</td>';
                    $statusString = '';

                    if ($order['status'] == 'created') {
                        $statusString = 'Đã đặt hàng';
                    } else if ($order['status'] == 'done') {
                        $statusString = 'Đã hoàn thành';
                    } else {
                        $statusString = 'Đã huỷ';
                    }

                    echo '<td>' . $statusString . '</td>';
                    echo '<td>' . $order['total'] . '</td>';
                    echo '<td><a class="btn btn-light" href ="order_details_history.php?id=' . $order['id'] . '">Xem chi tiết</a><td>';

                    if($order['status']=="cancel"){
                        echo '<td></td>';
                    }
                    else
                    {
                        echo '<td><a class="btn btn-light" href="#" onclick="confirmCancelOrder(' . $order['id'] . ')">Hủy</a></td>';
                    }


                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
    <a class="btn btn-light" href="index.php">Về trang chủ</a>
</body>
<script>
    function confirmCancelOrder(order_id) {
        if (confirm("Bạn có chắc muốn hủy đơn hàng không?")) {
            window.location.href = "cancel_order.php?id=" + order_id;
        }
    }
</script>

</html>