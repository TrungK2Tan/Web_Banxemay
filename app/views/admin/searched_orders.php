<?php include_once 'app/views/admin/header_admin.php'; ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    Kết quả tìm kiếm
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Danh sách đơn hàng đã tìm thấy
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Ngày đặt</th>
                                        <th>Địa chỉ</th>
                                        <th>Số điện thoại</th>
                                        <th>Tổng tiền</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Người đặt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($searchedOrders)): ?>
                                        <?php foreach ($searchedOrders as $order): ?>
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
                                            <td colspan="8">Không tìm thấy đơn hàng nào.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->

<?php include_once 'app/views/admin/footer_admin.php'; ?>
