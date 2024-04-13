<?php include_once 'app/views/share/header.php'; ?>

<div class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="product-card">
                    <div class="card">
                        <img src="/php/<?= $product['image']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="/php/product/detail/<?= $product['id'] ?>">
                                    <?= $product['name'] ?>
                                </a>
                            </h5>
                            <p class="card-text"><?= $product['description'] ?></p>
                            <p class="card-text">Giá: <?= number_format($product['price'], 0, ',', '.') ?> đ</p>
                            <div class="main-click">
                                <a href="/php/product/detail/<?= $product['id'] ?>" class="btn btn-primary">Mua Ngay</a>
                                <?php
                                if (SessionHelper::isLoggedIn()) {
                                    if ($_SESSION['role'] == 1) {
                                        echo '<a href="/php/product/delete/' . $product['id'] . '" class="btn btn-danger" onclick="return confirm(\'Bạn có chắc muốn xóa sản phẩm này?\')">Xóa</a>';
                                    }
                                }
                                ?>
                                <button class="btn btn-primary add-to-cart add-to-cart-btn"
                                    onclick="addToCart(<?= $product['id']; ?>)">Thêm vào giỏ hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
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
<?php include_once 'app/views/share/footer.php'; ?>
