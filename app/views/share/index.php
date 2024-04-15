<?php
include_once 'app/views/share/header.php';

// Lấy danh sách loại sản phẩm từ model
$categories = $this->productModel->getAllCategories();

// Tính toán số lượng sản phẩm trên mỗi trang
$itemsPerPage = 3;

// Tính tổng số lượng sản phẩm
$totalProducts = $this->productModel->getTotalProducts();

// Tính toán tổng số trang
$totalPages = ceil($totalProducts / $itemsPerPage);

// Xác định trang hiện tại
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính toán offset cho truy vấn SQL
$start = ($page - 1) * $itemsPerPage;

// Lấy danh sách sản phẩm cho trang hiện tại
$products = $this->productModel->getProductsPaginated($start, $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin thanh toán</title>
    <!-- Sử dụng Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Sử dụng thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/php/app/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <!-- Cột danh mục sản phẩm chiếm 20% -->
            <div class="col-md-3">
                <div class="p-3">
                    <div class="bg-dark text-white p-3 rounded">
                        <h5 class="text-center">LOẠI SẢN PHẨM</h5>
                        <ul class="list-unstyled">
                            <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="/php/product/category/<?= $category['id'] ?>"
                                    class="d-block text-white py-2 px-3 mb-2 rounded category-button"><?= $category['name']; ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Cột danh sách sản phẩm chiếm 80% -->
            <div class="col-md-9">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($products as $row): ?>
                    <div class="col">
                        <div class="product-card">
                            <div class="card">
                                <img src="/php/<?= $row['image']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/php/product/detail/<?= $row['id'] ?>">
                                            <?= $row['name'] ?>
                                        </a>
                                    </h5>
                                    <p class="card-text"><?= $row['description'] ?></p>
                                    <p class="card-text">Giá: <?= number_format($row['price'], 0, ',', '.') ?> đ</p>
                                    <div class="main-click">
                                        <a href="/php/product/detail/<?= $row['id'] ?>"
                                            class="btn btn-primary">Mua Ngay</a>
                                        <?php if (SessionHelper::isLoggedIn() && $_SESSION['role'] == 1): ?>
                                        <a href="/php/product/delete/<?= $row['id'] ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a>
                                        <?php endif; ?>
                                        <button class="btn btn-primary add-to-cart add-to-cart-btn"
                                            onclick="addToCart(<?= $row['id']; ?>)">Thêm vào giỏ hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

        <!-- Hiển thị liên kết phân trang -->
        <div class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/php?page=<?= $i ?>" class="btn btn-primary btn-lg <?= ($page == $i) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>

    <script>
        function addToCart(productId) {
            // Gửi yêu cầu AJAX để thêm sản phẩm vào giỏ hàng
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/php/shoppingcart/addToCart/' + productId, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Đã thêm sản phẩm vào giỏ hàng thành công
                    alert('Sản phẩm đã được thêm vào giỏ hàng!');
                } else {
                    // Xử lý lỗi
                    alert('Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.');
                }
            };
            xhr.send();
        }
    </script>
</body>

</html>

<?php
include_once 'app/views/share/footer.php'
?>