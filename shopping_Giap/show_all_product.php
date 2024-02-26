<?php
require_once("config/config.php");
require_once(ROOT . "/include/function.php");
spl_autoload_register("loadClass");
session_start();

$obj = new Product();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full products</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/style1.css" rel="stylesheet" />

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#">My Website</a>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">

                    <li><a class="nav-link " aria-current="page" href="index.php">Home</a></li>
                    <li><a class="nav-link active" href="show_all_product.php">All Products</a></li>
                    
                    <?php
                        if(empty($_SESSION['user'])){
                            ?>

                            <li class='nav-item dropdown'>
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo "Account"?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                                <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>
                                </ul>
                            </li>
                            <?php
                        } else {
                            $db = new db();
                            $sql = "SELECT * from user where email= :email";
                            $arr = array(':email' => $_SESSION['user']);
                            $user = $db->select($sql,$arr)[0];?>
                            <li class='nav-item dropdown'>
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= $user['fullname']?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="history.php">History shopping</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </li>

                            <?php
                        }
                    ?>
                </ul>
                <a href="cart.php" class="btn btn-outline-dark d-flex align-items-center text-decoration-none">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">
                        <?php
                        $count = isset($_SESSION['product_id']) ? count($_SESSION['product_id']) : 0;
                        echo $count;
                        ?>
                    </span>
                </a>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        
        <div class="d-lg-flex align-items-lg-center pt-2">
            <div class="form-inline d-flex align-items-center my-2 checkbox bg-light border mx-lg-2">
                <select name="manufacturer" id="country" class="bg-light" onchange="onSelectChanged()">
                    <option value="">Option</option>
                        <?php
                            $obj->getAllManufacturers();
                        ?>
                </select>
            </div>
        </div>

        <div class="content py-md-0 py-3">
            
            <section id="products">
                <div class="container py-3">
                    <div class="row" id="productContainer">
                        <?php
                        $totalPage = $obj->pagination();
                        ?>
                    </div>
                </div>
                <?php
                $manufacturer = isset($_GET['manufacturer']) ? $_GET['manufacturer'] : '';
                $category = isset($_GET['category']) ? $_GET['category'] : '';

                $queryParams = $_GET;
                unset($queryParams['page']); 
                
                echo '<nav aria-label="Page navigation example">
                      <ul class="pagination">';

                for ($i = 1; $i <= $totalPage; $i++) {
                    $queryParams['page'] = $i;
                    $queryString = http_build_query($queryParams);

                    echo '<li class="page-item"><a class="page-link" href=" '. BASE_URL .'show_all_product.php?' . $queryString . '">' . $i . '</a></li>';
                }

                echo '</ul>
                  </nav>';
                ?>

            </section>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script>
        function onSelectChanged() {
            var selectElement = document.getElementById('country');
            var manufacturerId = selectElement.value;

            var currentURL = window.location.href;
            var newURL = addToUrlParameter(currentURL, 'manufacturer', manufacturerId);

            window.location.href = newURL;
        }

        function handleTitleClick(event) {
            var clickedTitle = event.target;
            var categoryId = clickedTitle.dataset.category;

            var currentURL = window.location.href;
            var newURL = addToUrlParameter(currentURL, 'category', categoryId);

            window.location.href = newURL;


        }

        function addToUrlParameter(url, key, value) {
            var encodedValue = encodeURIComponent(value);
            var regex = new RegExp("([?&])" + key + "=[^&]*");

            if (regex.test(url)) {
                return url.replace(regex, '$1' + key + '=' + encodedValue);
            } else {
                var separator = url.includes('?') ? '&' : '?';
                return url + separator + key + '=' + encodedValue;
            }
        }
    </script>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET['add_to_cart'])) {

        $product_id = $_GET['product_id'];

        if (isset($_SESSION)) {
            if (!isset($_SESSION['product_id'])) {
                $_SESSION['product_id'][] = $product_id;
            } else {
                if (!in_array($product_id, $_SESSION['product_id'])) {
                    $_SESSION['product_id'][] = $product_id;
                }
            }
        } else {
            $_SESSION['product_id'][] = $product_id;
        }

    }
}
?>
</html>