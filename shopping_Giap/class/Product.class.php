<?php
class Product extends Db
{
    public function getRand()
    {
        $sql = "SELECT * from product order by rand() limit 8";
        $products = $this->select($sql);

        foreach ($products as $product) {
            echo '<div class="col mb-5">';
            echo '<div class="card h-100">';
            echo '<img class="card-img-top" src=img/' . $product['image'] . ' alt="..." width = "350px" height = "120px"/>';
            echo '<div class="card-body p-4">';
            echo '<div class="text-center">';
            echo '<h5  class="fw-bolder">' . $product['name'] . '</h5>';
            echo '<div class="d-flex justify-content-center small text-warning mb-2">';

            // for ($i = 0; $i < $product['review']; $i++) {
            //     echo '<div class="bi-star-fill"></div>';
            // }

            echo '</div>';
            // echo '<span class="text-muted text-decoration-line-through">$' . number_format($product['price'] + 300, 2) . '</span>';
            echo '$' . number_format($product['price'], 2);
            echo '</div>';
            echo '</div>';
            echo '<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <form action="index.php" method="GET">
                <input type="hidden" name="product_id" value="' . $product['id'] . '"> 
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-dark mt-auto" name="add_to_cart">Add to cart</button>
                </div>
            </form>
        </div>';
            echo '</div>';
            echo '</div>';
        }
    }

    public function getAllManufacturers()
    {
        $sql = "SELECT * from manufacturer";
        $manufacturers = $this->SELECT($sql);

        foreach ($manufacturers as $key => $value) {
            echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }
    }

    public function getAllCategories()
    {
        $sql = "SELECT * from categories";
        $categories = $this->SELECT($sql);

        foreach ($categories as $value) {
            $sql = "SELECT sum(stocks) from product where categories_id = :categoryId";
            $arr = array(":categoryId" => $value['id']);
            $sum = $this->SELECT($sql, $arr);

            echo '<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
            <a data-category="' . $value['id'] . '" id = "categories" onclick = "handleTitleClick(event)">' . $value['name'] . '</a> <span class="badge badge-primary badge-pill">' . $sum[0]['sum(stocks)'] . '</span></li>';
        }
    }

    public function pagination()
    {
        $manufacturerId = $_GET['manufacturer'] ?? null;
        $categoriesId = $_GET['category'] ?? null;

        $sql = "SELECT * FROM product WHERE 1 = 1";
        $arr = array();

        if ($manufacturerId !== null) {
            $sql .= " AND manufacturer_id = :manufacturerId";
            $arr[':manufacturerId'] = $manufacturerId;
        }

        if ($categoriesId !== null) {
            $sql .= " AND categories_id = :categoriesId";
            $arr[':categoriesId'] = $categoriesId;
        }

        $allProducts = $this->select($sql, $arr);
        $totalProduct = $this->getRowCount();

        $page = 1;
        $pageSize = 6;


        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        $totalPage = ceil($totalProduct / $pageSize);
        $start = ($page - 1) * $pageSize;
        $sql .= " LIMIT " . $start . "," . $pageSize;

        $products = $this->select($sql, $arr);

        foreach ($products as $key => $value) {
            echo '<div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1">
           <div class="card"> <img class="card-img-top" src="img/' . $value['image'] . '" height = 200>
           <div class="card-body">
               <h6 class="font-weight-bold pt-1">';
            echo $value['name'] . '</h6>
            <div class="text-muted description">' . 'description' . '</div>
            <div class="d-flex align-items-center product">';
            // for ($i = 0; $i < $value['review']; $i++) {
            //     echo '<div class="bi-star-fill"></div>';
            // }
            echo '</div><div class="d-flex align-items-center justify-content-between pt-3">
                <div class="d-flex flex-column">
                    <div class="h6 font-weight-bold">' . $value['price'] . ' USD</div>
                    <div class="text-muted rebate">';
            echo '</div>
            </div>
            <form action="show_all_product.php" method="GET">
                <input type="hidden" name="product_id" value="' . $value['id'] . '"> 
                <div class="text-center">
                    <button type="submit" name="add_to_cart">Add to cart</button>
                </div>
            </form></div></div></div></div>';
        }

        return $totalPage;
    }

    public function productCart()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $listProductId = $_SESSION['product_id'] ?? null;

            if ($listProductId != null) {

                foreach ($listProductId as $productId) {
                    $sql = "SELECT * from product where id = :productId";
                    $arr = array(":productId" => $productId);

                    $allProduct = $this->select($sql, $arr);
                    $product = $allProduct[0];

                    $sql = "SELECT categories.name 
                            FROM categories join product on product.categories_id = categories.id 
                            where product.id = :productId";

                    $allCategories = $this->select($sql, $arr);
                    $category = $allCategories[0];

                    echo '<div class="row border-top border-bottom">
                            <div class="row main align-items-center">
                            <div class="col-2"><img class="img-fluid" src="img/';
                    echo $product['image'] . '"></div>';
                    echo '  <div class="col">
                            <div class="row text-muted">' . $category['name'] . '</div>';
                    echo '  <div class="row">' . $product['name'] . '</div></div>';
                    echo '  <div class="col"><input type="number" class="quantityValue" value="1" min="1" max="' . $product['stocks'] . '" name="' . $productId . '"></div>';
                    echo '  <div class="col">$' . $product['price'] . '<a href = ?id=' . $productId . ' name = "delete" class="close">&#10005;</a></div></div></div>';
                }
            }
        }
    }
}
