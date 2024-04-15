<?php
require_once 'app/controllers/AdminController.php';

// Instantiate the AdminController
$adminController = new AdminController();

// Handle edit product request
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    $adminController->edit($productId); // Make sure you're passing $productId to the edit() method
}

// Kiểm tra nếu có yêu cầu xóa sản phẩm
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    // Xác định id sản phẩm cần xóa
    $productId = $_GET['id'];

    // Gọi hàm xóa sản phẩm từ đối tượng ProductModel hoặc thực hiện truy vấn cơ sở dữ liệu tương ứng
    // Ví dụ: $productModel->deleteProduct($productId);

    // Sau khi xóa sản phẩm, redirect về trang index
    header("Location: /php/admin/index");
    exit; // Dừng kịch bản
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TRANG ADMIN</title>
    <!-- Bootstrap Styles-->
    <link href="/php/app/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="/php/app/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="/php/app/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="/php/app/assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><i class="fa fa-gear"></i> <strong>TRANG CHỦ</strong></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div id="sideNav" href=""><i class="fa fa-caret-right"></i></div>
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu" href="#"><i class="fa fa-dashboard"></i> Quản lý sản phẩm</a>
                    </li>
                    <li>
                        <a href="order"><i class="fa fa-desktop"></i>Quản lý đơn hàng</a>
                    </li>
                    <li>
                        <a href="chart.html"><i class="fa fa-bar-chart-o"></i> Quản lý tài khoản</a>
                    </li>
                </ul>

            </div>

        </nav>
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
                            <input placeholder="search san pham" />
                            <button><i class="fa fa-search"></i></button>
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
                                                        <a href="/php/admin/edit?id=<?php echo $product['id']; ?>" class="btn btn-primary">Sửa</a>

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