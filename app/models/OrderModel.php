<?php
class OrderModel {
    private $conn;
    private $table_name = "orders";
    private $table_detail = "order_details";
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function createOrder($orderDate, $address, $phone, $totalPrice, $accountId) {
        // Tạo câu lệnh SQL để chèn dữ liệu vào bảng `orders`
        $query = "INSERT INTO " . $this->table_name . " (`Date`, `Address`, `Phone`, `Total`, `AccountId`) VALUES (:orderDate, :address, :phone, :total, :accountId)";
                
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->conn->prepare($query);

        // Làm sạch và gán dữ liệu vào câu lệnh
        $stmt->bindParam(':orderDate', $orderDate);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':total', $totalPrice); 
        $stmt->bindParam(':accountId', $accountId);

        var_dump($orderDate, $address, $phone, $totalPrice, $accountId);
        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            // Trả về id của đơn hàng mới được tạo
            return $this->conn->lastInsertId();
        }

        // Trả về false nếu không thể tạo đơn hàng
        return false;
    }

    public function createOrderDetail($orderId, $productId, $quantity) {
        try {
            $query = "INSERT INTO " . $this->table_detail . " (OrderId, ProductId, Amount) VALUES (:orderId, :productId, :quantity)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':orderId', $orderId);
            $stmt->bindParam(':productId', $productId);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Log or display the error message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getOrderHistory($accountId)
    {
        $sql = "SELECT o.Id AS OrderId, o.Date, o.Address, o.Phone, o.Total, od.ProductId, p.Name AS ProductName, od.Amount
                FROM `" . $this->table_name . "` AS o
                INNER JOIN `" . $this->table_detail . "` AS od ON o.Id = od.OrderId
                INNER JOIN `products` AS p ON od.ProductId = p.Id
                WHERE o.AccountId = :accountId";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':accountId', $accountId);
        $stmt->execute();
    
        $orderHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $orderHistory;
    }
    
    
    
    
}
?>