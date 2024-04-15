<?php
class AdminModel
{
    private $conn;
    private $table_name = "products";
    private $table_name_order = "orders";
    private $table_name_order_detail = "order_details";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    

    public function getAllOrders()
{
    $query = "SELECT o.Id AS OrderId, o.Date, o.Address, o.Phone, o.Total, od.ProductId, p.Name AS ProductName, od.Amount, u.name
                FROM `" . $this->table_name_order . "` AS o
                INNER JOIN `" . $this->table_name_order_detail . "` AS od ON o.Id = od.OrderId
                INNER JOIN `products` AS p ON od.ProductId = p.Id
                INNER JOIN `accout` AS u ON o.AccountId = u.Id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function searchOrders($searchQuery)
{
    // Query to search for orders based on the product name
    $query = "SELECT o.Id AS OrderId, o.Date, o.Address, o.Phone, o.Total, od.ProductId, p.Name AS ProductName, od.Amount, u.name
                FROM `" . $this->table_name_order . "` AS o
                INNER JOIN `" . $this->table_name_order_detail . "` AS od ON o.Id = od.OrderId
                INNER JOIN `products` AS p ON od.ProductId = p.Id
                INNER JOIN `accout` AS u ON o.AccountId = u.Id
                WHERE p.Name LIKE :searchQuery";

    // Prepare the query
    $stmt = $this->conn->prepare($query);

    // Bind the search query parameter
    $searchParam = "%" . $searchQuery . "%";
    $stmt->bindParam(":searchQuery", $searchParam);

    // Execute the query
    $stmt->execute();

    // Fetch all matching orders
    $searchedOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $searchedOrders;
}
    function readAll()
    {
        $query = "SELECT id, name, description, price, image FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    public function getAllCategories()
    {
        $query = "SELECT id, name FROM category"; // Assuming 'name' is the column for category names
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    public function getProductsByCategory($categoryId)
    {
        $query = "SELECT id, name, description, price, image FROM " . $this->table_name . " WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct($name, $description, $price, $image,$category)
    {
        // Kiểm tra ràng buộc đầu vào
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        // Truy vấn tạo sản phẩm mới

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, image, category_id) VALUES (:name, :description, :price, :image,:category_id)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        // Không cần làm sạch dữ liệu của $price và $image vì chúng không được chèn trực tiếp vào câu lệnh SQL.

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':category_id', $category);


        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    //updateProduct
    public function updateProduct($id, $name, $description, $price, $image = null,$category)
    {
        // Kiểm tra ràng buộc đầu vào
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }

        if (count($errors) > 0) {
            return $errors;
        }

        // Cập nhật dữ liệu sản phẩm

        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description, price = :price, category_id = :category_id";

        // Nếu có hình ảnh mới được tải lên, cập nhật đường dẫn hình ảnh mới
        if ($image !== null) {
            $query .= ", image = :image";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        // Không cần làm sạch dữ liệu của $price vì nó không được chèn trực tiếp vào câu lệnh SQL.

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':category_id', $category);


        // Nếu có hình ảnh mới được tải lên, gán dữ liệu vào câu lệnh
        if ($image !== null) {
            $stmt->bindParam(':image', $image);
        }

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " where id = $id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    //xóa 
    public function getAllProducts()
    {
        $query = "SELECT id, name, description, price, image FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function searchProducts($searchQuery)
{
    // Tạo câu truy vấn SQL để tìm kiếm sản phẩm theo tên hoặc mô tả
    $query = "SELECT * FROM " . $this->table_name . " WHERE name LIKE :searchQuery OR description LIKE :searchQuery";

    // Chuẩn bị câu truy vấn
    $stmt = $this->conn->prepare($query);

    // Bind các tham số và thực thi câu truy vấn
    $searchParam = "%" . $searchQuery . "%";
    $stmt->bindParam(":searchQuery", $searchParam);
    $stmt->execute();

    // Trả về kết quả tìm kiếm
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function deleteProduct($id)
    {
        // Chuẩn bị câu lệnh SQL để xóa sản phẩm
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Chuẩn bị và thực thi câu lệnh
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        // Thực thi câu lệnh và trả về kết quả
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTotalProducts()
    {
        // Thực hiện truy vấn SQL để đếm số lượng sản phẩm
        $query = "SELECT COUNT(*) as total FROM products";
        $statement = $this->conn->prepare($query); // Sửa từ $this->db thành $this->conn
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getProductsPaginated($start, $perPage)
    {
        // Thực hiện truy vấn SQL để lấy danh sách sản phẩm với phân trang
        $query = "SELECT * FROM products LIMIT :start, :perPage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function searchProductsWithPagination($keyword, $start, $itemsPerPage)
    {
        $query = "SELECT * FROM products WHERE name LIKE :keyword LIMIT :start, :itemsPerPage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
        $stmt->execute();

        // Lấy tổng số sản phẩm
        $totalProducts = $stmt->rowCount();

        // Tính toán tổng số trang
        $totalPages = ceil($totalProducts / $itemsPerPage);

        // Lấy danh sách sản phẩm trên trang hiện tại
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['products' => $products, 'totalPages' => $totalPages];
    }
}


