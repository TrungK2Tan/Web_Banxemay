<?php

class AccountModel{
    private $conn;
    private $table_name = "accout";
    

    public function __construct($db) {
        $this->conn = $db;
    }

    function getAccountByEmail($email){
        $query = "SELECT * FROM ". $this->table_name." where email = :email";

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

}