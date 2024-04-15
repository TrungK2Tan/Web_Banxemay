<?php
require_once 'app/controllers/AdminController.php';
include_once 'app/views/admin/header_admin.php';
// Instantiate the AdminController
$adminController = new AdminController();


// Kiểm tra nếu có yêu cầu xóa sản phẩm
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    // Xác định id sản phẩm cần xóa
    $productId = $_GET['id'];

    // Gọi hàm xóa sản phẩm từ đối tượng ProductModel hoặc thực hiện truy vấn cơ sở dữ liệu tương ứng
    // Ví dụ: $productModel->deleteProduct($productId);

    // Sau khi xóa sản phẩm, redirect về trang index
    header("Location: /php/admin");
    exit; // Dừng kịch bản
}

?>
<!-- /. NAV SIDE  -->
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <h1 class="page-header">
                        Quản lý <small>sản phẩm</small>
                    </h1>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <form action="/php/admin/search_product" method="GET">
                        <input type="text" name="search" placeholder="Nhập từ khóa tìm kiếm">
                        <button type="submit">Tìm kiếm</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Danh sách sản phẩm
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Mô tả</th>
                                        <th>Giá tiền</th>
                                        <th>Hình ảnh</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td><?php echo $product['id']; ?></td>
                                                <td><?php echo $product['name']; ?></td>
                                                <td><?php echo $product['description']; ?></td>
                                                <td><?php echo $product['price']; ?></td>
                                                <td><img src="<?php echo $product['image']; ?>" alt="Product Image"
                                                        style="width: 100px; height: 100px;"></td>
                                                <td>
                                                    <a href="/php/admin/edit?id=<?php echo $product['id']; ?>"
                                                        class="btn btn-primary">Sửa</a>

                                                    <a href="/php/admin/index?action=delete&id=<?php echo $product['id']; ?>"
                                                        class="btn btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">Không có sản phẩm.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <a href="/php/admin/add" class="btn btn-success">Thêm sản phẩm</a>

            </div>
        </div>
        <!-- /. ROW  -->
    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- JS Scripts-->
<!-- jQuery Js -->
<script src="/php/app/assets/js/jquery-1.10.2.js"></script>
<!-- Bootstrap Js -->
<script src="/php/app/assets/js/bootstrap.min.js"></script>

<!-- Metis Menu Js -->
<script src="/php/app/assets/js/jquery.metisMenu.js"></script>
<!-- Morris Chart Js -->
<script src="/php/app/assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="/php/app/assets/js/morris/morris.js"></script>


<script src="/php/app/assets/js/easypiechart.js"></script>
<script src="/php/app/assets/js/easypiechart-data.js"></script>

<script src="/php/app/assets/js/Lightweight-Chart/jquery.chart.js"></script>

<!-- Custom Js -->
<script src="/php/app/assets/js/custom-scripts.js"></script>


</body>

</html>