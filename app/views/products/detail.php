
<?php
include_once 'app/views/share/header.php'
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
<div class="row">
    <img src="/php/<?= $product->image ?>" style="width: 50%"/>
    <div style="width: 50%">
    <h3 class="card-title" style=""><?= $product->name ?></h3>
    <p class="card-text" style="padding: 5px;"><?= $product->description ?></p>
    <p class="card-text">Giá: <?= number_format($product->price, 0, ',', '.') ?> đ</p>

    <form id="addToCartForm" action="/php/shoppingcart/addToCart/<?= $product->id ?>" method="POST">
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="btn btn-primary add-to-cart add-to-cart-btn btn-cl">Thêm vào giỏ hàng</button>
    </form>
    <?php
        if (SessionHelper::isLoggedIn()) {
            if ($_SESSION['role'] == 1) {
                echo '<a href="/php/product/edit/' . $product->id . '" class="btn btn-warning" style="padding: 5px 100px; margin: 4px;">Sửa</a>';
            }
        }
    ?>
    </div>
</div>

<?php include_once 'app/views/share/footer.php'; ?>

<!-- Script JavaScript -->
<script>
    document.getElementById('addToCartForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        // Gửi yêu cầu AJAX để thêm sản phẩm vào giỏ hàng
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/php/shoppingcart/addToCart/<?= $product->id ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Đã thêm sản phẩm vào giỏ hàng thành công
                alert('Sản phẩm đã được thêm vào giỏ hàng!');
                location.reload(); // Reload the page
            } else {
                // Xử lý lỗi
                alert('Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.');
            }
        };
        xhr.send(new FormData(this));
    });
</script>
</body>

</html>


<?php
include_once 'app/views/share/footer.php'
?>