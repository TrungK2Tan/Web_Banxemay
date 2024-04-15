<?php
// Include header
include_once 'app/views/share/header.php';

// Khởi tạo đối tượng Database
$database = new Database();
$db = $database->getConnection();

// Thiết lập số sản phẩm trên mỗi trang và trang hiện tại
$records_per_page = 6;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $records_per_page;

// Lấy từ khóa tìm kiếm từ URL
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Truy vấn cơ sở dữ liệu để lấy tổng số sản phẩm
$query_total = "SELECT COUNT(*) AS total FROM products WHERE name LIKE :keyword";
$stmt_total = $db->prepare($query_total);
$stmt_total->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
$stmt_total->execute();
$row_total = $stmt_total->fetch(PDO::FETCH_ASSOC);
$total_records = $row_total['total'];

// Tính toán số trang và sản phẩm cần hiển thị
$total_pages = ceil($total_records / $records_per_page);

// Truy vấn cơ sở dữ liệu để lấy sản phẩm cho trang hiện tại
$query = "SELECT * FROM products WHERE name LIKE :keyword LIMIT :start_from, :records_per_page";
$stmt = $db->prepare($query);
$stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
$stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products</title>

    <!-- Sử dụng Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- CSS để đảm bảo ảnh sản phẩm có cùng kích thước -->
    <style>
        .product-card .card-img-top {
            width: 100%;
            height: 200px; /* Đặt chiều cao cố định cho ảnh */
            object-fit: cover; /* Đảm bảo ảnh sẽ được căn chỉnh và cắt tỉa phù hợp */
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($stmt as $product): ?>
                <div class="col">
                    <div class="product-card">
                        <div class="card">
                            <img src="/php/<?= $product['image']; ?>" class="card-img-top" alt="<?= $product['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product['name']; ?></h5>
                                <p class="card-text"><?= $product['description']; ?></p>
                                <p class="card-text">Giá: <?= number_format($product['price'], 0, ',', '.') ?> đ</p>
                                <div class="main-click">
                                    <a href="/php/product/detail/<?= $product['id'] ?>" class="btn btn-primary">Mua Ngay</a>
                                    <button class="btn btn-primary add-to-cart add-to-cart-btn"
                                        onclick="addToCart(<?= $product['id']; ?>)">Thêm vào giỏ hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Phân trang -->
            <ul class="pagination justify-content-center mt-4">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?= ($i == $current_page) ? 'active' : ''; ?>">
                        <a class="btn btn-primary" href="/php/search.php?keyword=<?= $keyword ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
    </div>

    <!-- Sử dụng Bootstrap JS và Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

<?php include_once 'app/views/share/footer.php'; ?>