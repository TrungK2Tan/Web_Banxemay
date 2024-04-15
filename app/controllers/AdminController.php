<?php
require_once 'app/models/AdminModel.php';

class AdminController
{
    private $adminModel;
    private $db;

    public function __construct()
    {
        // Establish a database connection and initialize the product model
        $this->db = (new Database())->getConnection();
        $this->adminModel = new AdminModel($this->db);
    }

    public function order()
    {
        // Get all orders from the model
        $orders = $this->adminModel->getAllOrders();

        // Pass orders data to the view
        include 'app/views/admin/order.php';
    }
    
    public function exportToExcel()
    {
        // Get all orders from the model
        $orders = $this->adminModel->getAllOrders();

        // Tạo một đối tượng PHPExcel
        $objPHPExcel = new PHPExcel();

        // Thiết lập các thông tin cho file Excel ở đây

        // Thiết lập header cho việc tải file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="order_list.xls"');
        header('Cache-Control: max-age=0');

        // Ghi file Excel ra output
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function index()
    {
        // Check if there's a request to delete a product
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $productId = $_GET['id'];
            $this->deleteProduct($productId);
        }
        if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
            $productId = $_GET['id'];
            $this->edit($productId); // Make sure you're passing $productId to the edit() method
        }

        // Retrieve all products
        $products = $this->adminModel->getAllProducts();

        // Include the index view
        include 'app/views/admin/index.php';
    }

    public function getProductById($productId)
    {
        // Gọi phương thức getProductById từ ProductModel để lấy thông tin sản phẩm từ cơ sở dữ liệu
        $product = $this->adminModel->getProductById($productId);
        return $product;
    }
    public function add()
    {
        // Debugging: Check session role
        // echo "Session role: " . $_SESSION['role']; // Debugging

        if (SessionHelper::isAdmin() == true) {
            header('Location: /php/account/login');
        }
        include_once 'app/views/admin/add_product.php';
    }


    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';

            // Xử lý tải lên hình ảnh đại diện
            if (isset($_FILES["image"])) {
                $uploadResult = $this->uploadImage($_FILES["image"]);
                if ($uploadResult) {
                    // Lưu đường dẫn của hình ảnh đại diện vào CSDL
                    $result = $this->adminModel->createProduct($name, $description, $price, $uploadResult);
                } else {
                    // Xử lý lỗi tải lên ở đây nếu cần thiết
                }

            }



            if (is_array($result)) {
                // Có lỗi, hiển thị lại form với thông báo lỗi
                $errors = $result;
                include 'app/views/admin'; // Đường dẫn đến file form sản phẩm
            } else {
                // Không có lỗi, chuyển hướng ve trang chu hoac trang danh sach
                header('Location: /php');
            }
        }

    }


    function uploadImage($file)
    {
        $targetDirectory = "app/image/";
        $targetFile = $targetDirectory . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là hình ảnh thực sự hay không
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Kiểm tra kích thước file
        if ($file["size"] > 500000) { // Ví dụ: giới hạn 500KB
            $uploadOk = 0;
        }

        // Kiểm tra định dạng file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }

        // Kiểm tra nếu $uploadOk bằng 0
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                return false;
            }
        }
    }

    public function edit($id)
    {

        $product = $this->adminModel->getProductById($id);

        // var_dump($product);
        // die();

        if ($product) {
            include_once 'app/views/admin/edit_product.php';
        } else {
            include_once 'app/views/share/not-found.php';
        }
    }

    // update
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';

            // Kiểm tra xem sản phẩm có tồn tại không
            $product = $this->adminModel->getProductById($id);
            if (!$product) {
                include_once 'app/views/share/not-found.php';
                return;
            }

            // Xử lý tải lên hình ảnh đại diện
            if (isset($_FILES["image"])) {
                $uploadResult = $this->uploadImage($_FILES["image"]);
                if ($uploadResult) {
                    // Lưu đường dẫn của hình ảnh đại diện vào CSDL
                    $result = $this->adminModel->updateProduct($id, $name, $description, $price, $uploadResult);
                } else {
                    // Lỗi tải lên
                    // Bạn có thể xử lý lỗi ở đây nếu cần thiết
                }
            } else {
                // Nếu không có hình ảnh mới được tải lên, chỉ cập nhật thông tin sản phẩm
                $result = $this->adminModel->updateProduct($id, $name, $description, $price);
            }

            if (is_array($result)) {
                // Có lỗi, hiển thị lại form với thông báo lỗi
                $errors = $result;
                include 'app/views/admin/edit_product.php'; // Đường dẫn đến file form sửa sản phẩm
            } else {
                // Không có lỗi, chuyển hướng về trang chi tiết sản phẩm
                header("Location: /php/product/detail/$id");
            }
        }
    }
    public function deleteProduct($productId)
    {
        // Delete the product
        $result = $this->adminModel->deleteProduct($productId);

        if ($result === true) {
            // Product deleted successfully, redirect to admin index
            header("Location: /php/admin/");
            exit;
        } else {
            // Handle errors
            // You can set an error message here and redirect back to the admin index
        }
    }

    // Add other admin-related methods here
}
?>