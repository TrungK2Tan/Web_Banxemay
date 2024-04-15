<?php

class AccountModel{
    private $conn;
    private $table_name = "accout"; // Đúng tên bảng là "account", không phải "accout"
    

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAccountByEmail($email){
        $query = "SELECT * FROM ". $this->table_name." WHERE email = :email"; // Thêm dấu cách trước WHERE

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function createAccount($email, $name, $password)
    {
        // Giá trị mặc định cho role_id
        $defaultRoleId = 2; // Giả sử 'user' có id là 1
        
        $query = "INSERT INTO " . $this->table_name . " (email, name, password, role_id) VALUES (:email, :name, :password, :roleId)";
        $stmt = $this->conn->prepare($query);
        
        // Bắt đầu thêm dữ liệu và gán giá trị mặc định cho role_id
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':roleId', $defaultRoleId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table_name; // Sửa table_user thành table_name
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id"; // Sửa table_user thành table_name
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($username, $password, $email) {
        $query = "INSERT INTO " . $this->table_name . " (name, password, email, role_id) VALUES (:name, :password, :email, :role_id)";
        $stmt = $this->conn->prepare($query);
        $role_id = 2; // ID của vai trò "user"
        $stmt->bindParam(':name', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role_id', $role_id);
        return $stmt->execute();
    }    
    
    public function updateUser($id, $name, $password, $email) {
        $query = "UPDATE " . $this->table_name . " SET name = :name, password = :password, email = :email WHERE id = :id"; // Sửa table_user thành table_name
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id"; // Sửa table_user thành table_name
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}