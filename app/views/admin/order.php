<?php
// Tính tổng doanh thu
$totalRevenue = 0;
if (isset($orders) && !empty($orders)) {
    foreach ($orders as $order) {
        $totalRevenue += $order['Total'];
    }
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
                        <a href="index"><i class="fa fa-dashboard"></i> Quản lý sản phẩm</a>
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
                                Quản lý <small>đơn hàng </small>
                            </h1>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <input placeholder="search san pham" />
                            <button><i class="fa fa-search"></i></button>
                            <button onclick="exportToExcel()"><i class="fa fa-file-excel-o"></i> Xuất Excel</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Danh sách đơn hàng đã đặt
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th >Order ID</th>
                                                <th>Ngày đặt </th>
                                                <th>Địa chỉ</th>
                                                <th>Số điện thoại </th>
                                                <th>Tổng tiền</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Người đặt</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($orders) && !empty($orders)): ?>
                                                <?php foreach ($orders as $order): ?>
                                                    <tr>
                                                        <td><?php echo $order['OrderId']; ?></td>
                                                        <td><?php echo $order['Date']; ?></td>
                                                        <td><?php echo $order['Address']; ?></td>
                                                        <td><?php echo $order['Phone']; ?></td>
                                                        <td><?php echo number_format($order['Total'], 0, ',', '.') ?> đ</td>
                                                        <td><?php echo $order['ProductName']; ?></td>
                                                        <td><?php echo $order['Amount']; ?></td>
                                                        <td><?= $order['name']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8">Không có đơn hàng nào.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>


                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
    <div class="col-md-12">
        <h4 class="page-header">Tổng doanh thu: <?php echo isset($totalRevenue) ? number_format($totalRevenue, 0, ',', '.') . ' đ' : '0 đ'; ?></h4>
    </div>
</div>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script>
       function exportToExcel() {
    // Tạo một yêu cầu HTTP GET đến endpoint để xuất Excel
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'order/exportToExcel', true);
    xhr.responseType = 'blob'; // Định dạng dữ liệu trả về là blob (binary large object)

    xhr.onload = function () {
        if (this.status === 200) {
            // Tạo một URL tạm thời cho blob được trả về
            var url = window.URL.createObjectURL(this.response);

            // Tạo một thẻ a để tải về file Excel
            var a = document.createElement('a');
            a.href = url;
            a.download = 'order_list.xls'; // Tên file được tải về
            document.body.appendChild(a);
            a.click();

            // Giải phóng URL tạm thời sau khi đã tải về
            window.URL.revokeObjectURL(url);
        }
    };

    xhr.send();
}

    </script>
 

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