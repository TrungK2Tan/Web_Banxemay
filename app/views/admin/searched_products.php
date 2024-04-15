<?php
include_once 'app/views/admin/header_admin.php';
?>
<div id="page-wrapper">
    <div id="page-inner">
        <h1>Kết quả tìm kiếm</h1>
        <?php if (!empty($searchedProducts)): ?>
            <ul>
                <?php foreach ($searchedProducts as $product): ?>
                    <li>
                        <h2><?php echo $product['name']; ?></h2>
                        <p><?php echo $product['description']; ?></p>
                        <p>Giá: <?php echo $product['price']; ?></p>
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"
                            style="max-width: 200px;">
                        <!-- Add any additional product information you want to display -->
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php else: ?>
    <p>Không tìm thấy sản phẩm nào phù hợp.</p>
<?php endif; ?>
<!-- Add any necessary JavaScript here -->
</body>

</html>