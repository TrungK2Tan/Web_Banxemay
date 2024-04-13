<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <!-- Sử dụng Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .product-name {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .btn-action {
            margin-left: 5px;
        }

        .total-section {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>


    <div class="container">
        <h1 class="mt-5">Giỏ hàng của bạn</h1>

        <?php if (empty($cartItems)) : ?>
            <div class="alert alert-info mt-3" role="alert">
                Giỏ hàng của bạn đang trống.
                <a href="/php/" class="btn btn-primary btn-sm">Tìm kiếm sản phẩm đi nào</a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Tổng</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $productId => $productInfo) : ?>
                            <tr>
                                <td class="product-name"><?php echo $productInfo['name']; ?></td>
                                <td>
                                    <!-- Input number để thay đổi số lượng sản phẩm -->
                                    <input type="number" class="form-control quantity-input" value="<?php echo $productInfo['quantity']; ?>" min="1">
                                </td>
                                <td><?php echo number_format($productInfo['price'], 0, ',', '.') ?> đ</td>
                                <td class="total-price"><?php echo number_format($productInfo['quantity'] * $productInfo['price'], 0, ',', '.') ?> đ</td>

                                <td>
                                    <!-- Link để xóa sản phẩm khỏi giỏ hàng  -->
                                    <a href="/php/shoppingcart/removeCartItem/<?php echo $productId; ?>" class="btn btn-danger btn-sm btn-action">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

            <p id="totalQuantity" class="total-section">Tổng số lượng sản phẩm: <?php echo count($cartItems); ?></p>
            <p class="total-section">Tổng tiền: <span id="totalPrice"><?php echo number_format($totalPrice, 0, ',', '.') ?> đ</span></p>


            <?php if (isset($_SESSION['username'])) : ?>
                <!-- Nếu đã đăng nhập, hiển thị nút thanh toán -->
                <a href="/php/shoppingcart/checkout" class="btn btn-success btn-action">Thanh toán</a>
            <?php else : ?>
                <!-- Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập -->
                <a href="/php/account/login" class="btn btn-primary btn-action">Đăng nhập để thanh toán</a>
            <?php endif; ?>

            <a href="/php/" class="btn btn-primary btn-action">Tiếp tục mua sắm</a>
        <?php endif; ?>
    </div>

    <!-- Sử dụng thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       // Lắng nghe sự kiện khi số lượng sản phẩm thay đổi
    $('.quantity-input').on('input', function() {
        var totalQuantity = 0;
        $('.quantity-input').each(function() {
            totalQuantity += parseInt($(this).val());
        });
        $('#totalQuantity').text('Tổng số lượng sản phẩm: ' + totalQuantity);
        
        var quantity = $(this).val();
        var price = parseFloat($(this).closest('tr').find('td:eq(2)').text());
        var totalPrice = quantity * price;
        $(this).closest('tr').find('.total-price').text(totalPrice.toFixed(2));
        updateTotalPrice();
    });

    // Cập nhật tổng tiền
    function updateTotalPrice() {
        var totalPrice = 0;
        $('.total-price').each(function() {
            totalPrice += parseFloat($(this).text());
        });
        $('#totalPrice').text(totalPrice.toFixed(2));
    }
    </script>
</body>

</html>
