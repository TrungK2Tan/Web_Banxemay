<?php
include_once 'app/controllers/AdminController.php'; 
class AccountController
{

    private $db;
    private $accountModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    function register()
    {
        include_once 'app/views/account/register.php';
    }

    function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $name = $_POST['name'] ?? '';
            $pass = $_POST['password'] ?? '';
            $confirmPass = $_POST['confirmPassword'] ?? '';

            $errors = [];
            if (empty($email)) {
                $errors['email'] = "Vui long nhap Email";
            }
            if (empty($name)) {
                $errors['name'] = "Vui long nhap Full Name";
            }
            if (empty($pass)) {
                $errors['pass'] = "Vui long nhap Password";
            }
            if ($pass != $confirmPass) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận MK phải giống nhau!";
            }
            //kiểm tra Email đã tồn tại trong CSDL hay chưa?
            $emailExist = $this->accountModel->getAccountByEmail($email);

            if ($emailExist) {
                $errors['ExistEmail'] = "Email tài khoản đã tồn tại!";
            }

            if (count($errors) > 0) {
                // var_dump($errors);
                include_once 'app/views/account/register.php';
            } else {
                //mã hóa mật khẩu
                $hashedPassword = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->createAccount($email, $name, $hashedPassword);
                if ($result) {
                    header('Location: /php/account/login');
                } else {
                    $errors['sql'] = "Lỗi server không thể truy vấn!";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }

    function login()
    {
        include_once 'app/views/account/login.php';
    }

    function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $pass = $_POST['password'] ?? '';

            $errors = [];
            if (empty($email)) {
                $errors['email'] = "Vui long nhap Email";
            }
            if (empty($pass)) {
                $errors['pass'] = "Vui long nhap Password";
            }

            //lấy thông tin tài khoản trong csdl theo email
            $account = $this->accountModel->getAccountByEmail($email);

            if ($account && password_verify($pass, $account->password)) {
                //đúng tài khoản
                $_SESSION['username'] = $account->email;
                $_SESSION['role'] = $account->role_id;
                $_SESSION['name'] = $account->name;
                $_SESSION['accountId'] = $account->id; // Đặt accountId vào session

                header ('Location: /php');
                  // Chuyển hướng người dùng dựa trên role
            if ($_SESSION['role'] == 1) {
                header('Location: /php/admin/'); // Đường dẫn tới trang admin
             } else {
                header('Location: /php/'); // Đường dẫn tới trang người dùng
            }
            }else if ($account && !password_verify($pass, $account->password))
            {
                $errors['account'] = "Sai mat khau roi!";
                include_once 'app/views/account/login.php';
            }  
            else {
                $errors['account'] = "Tài khoản không tồn tại!";
                include_once 'app/views/account/login.php';
            }
        }
    }

    function logout(){
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        unset($_SESSION['name']);
        header('Location: /php/account/login');
    }

    public function AccountManagement()
    {
        // Retrieve all users
        $users = $this->accountModel->getAllUsers();

        // Include the index view
        include 'app/views/admin/AccountManagement.php';
    }


    public function addUser()
    {
        // Include the add user view
        include 'app/views/admin/add_user.php';
    }

    public function saveUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve user data from the form
            $username = $_POST['name'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';

            // Create the user
            $result = $this->accountModel->addUser($username, $password, $email);

            if ($result === true) {
                $_SESSION['success_message'] = "Người dùng đã được tạo thành công!";
                // User created successfully, redirect to admin index
                header("Location: /php/account/AccountManagement");
                exit;
            } else {
                // Handle errors
                // You can set an error message here and redirect back to the add user form
            }
        }
        
    }
    public function editUser($userId)
    {
        // Retrieve user data by ID
        $user = $this->accountModel->getUserById($userId);

        if ($user) {
            // Include the edit user view
            include 'app/views/admin/edit_user.php';
        } else {
            // Handle user not found
            // You can set an error message here and redirect back to the admin index
        }
    }

    public function updateUser($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve user data from the form
            $name = $_POST['name'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';

            // Update the user
            $result = $this->accountModel->updateUser($userId, $name, $password, $email);

            if ($result === true) {
                // User updated successfully, redirect to admin index
                header("Location: /php/admin/user");
                exit;
            } else {
                // Handle errors
                // You can set an error message here and redirect back to the edit user form
            }
        }
    }

    public function deleteUser($userId)
    {
        // Delete the user
        $result = $this->accountModel->deleteUser($userId);

        if ($result === true) {
            // User deleted successfully, redirect to admin index
            header("Location: /php/admin/user");
            exit;
        } else {
            // Handle errors
            // You can set an error message here and redirect back to the admin index
        }
    }
}