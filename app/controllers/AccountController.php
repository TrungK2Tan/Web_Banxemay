<?php
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
}