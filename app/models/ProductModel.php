<?php
class ProductModel
{
    private $conn;
    private $table_name = "products";

    public function __construct($db)
    {
        $this->conn = $db;
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
    
    public function createProduct($name, $description, $price, $image)
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

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, image) VALUES (:name, :description, :price, :image)";
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

    //updateProduct
    public function updateProduct($id, $name, $description, $price, $image = null)
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

        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description, price = :price";

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

    //xóa 

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




}