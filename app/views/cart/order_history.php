<?php
include_once 'app/views/share/header.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm đã đặt</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <link rel="stylesheet" href="/php/app/css/styles.css">
</head>
<body>
    <h1>Order History</h1>
    <?php if (!empty($orderHistory)): ?>
        <table>
            <thead>
                <tr>
                    <th hidden>Order ID</th>
                    <th>Ngày đặt </th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại </th>
                    <th>Tổng tiền</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderHistory as $order): ?>
                    <tr>
                        <td hidden><?php echo $order['OrderId'];?></td>
                        <td><?php echo $order['Date']; ?></td>
                        <td><?php echo $order['Address']; ?></td>
                        <td><?php echo $order['Phone']; ?></td>
                        <td><?php echo number_format($order['Total'], 0, ',', '.') ?> đ</td>
                        <td><?php echo $order['ProductName']; ?></td>
                        <td><?php echo $order['Amount']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</body>
</html>
<?php
include_once 'app/views/share/footer.php'
?>