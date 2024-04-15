<?php
// Tính tổng doanh thu
$totalRevenue = 0;
if (isset($orders) && !empty($orders)) {
    foreach ($orders as $order) {
        $totalRevenue += $order['Total'];
    }
}
?>
<?php include_once 'app/views/admin/header_admin.php'; ?>

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
                    <form method="GET" action="search">
                        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm" />
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
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
                                        <th>Order ID</th>
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
                <h4 class="page-header">Tổng doanh thu:
                    <?php echo isset($totalRevenue) ? number_format($totalRevenue, 0, ',', '.') . ' đ' : '0 đ'; ?></h4>
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