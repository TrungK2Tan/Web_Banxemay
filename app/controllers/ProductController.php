<?php
class ProductController {

    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function getProductById($productId) {
        // Gọi phương thức getProductById từ ProductModel để lấy thông tin sản phẩm từ cơ sở dữ liệu
        $product = $this->productModel->getProductById($productId);
        return $product;
    }
    public function add() {
        // Debugging: Check session role
        // echo "Session role: " . $_SESSION['role']; // Debugging
    
        if(SessionHelper::isAdmin() == true){
            header ('Location: /php/account/login');
        }
        include_once 'app/views/products/create.php';
    }
    
    public function category($categoryId) {
        // Gọi phương thức từ ProductModel để lấy các sản phẩm thuộc category
        $products = $this->productModel->getProductsByCategory($categoryId);
        // Pass data vào view và hiển thị
        include_once 'app/views/products/category.php';
    }
    
    
    public function save(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';

             // Xử lý tải lên hình ảnh đại diện
             if (isset($_FILES["image"])) {
                $uploadResult = $this->uploadImage($_FILES["image"]);
                if ($uploadResult) {
                    // Lưu đường dẫn của hình ảnh đại diện vào CSDL
                    $result = $this->productModel->createProduct($name, $description, $price, $uploadResult);
                } else {
                    // Lỗi tải lên
                }
            }

            

            if (is_array($result)) {
                // Có lỗi, hiển thị lại form với thông báo lỗi
                $errors = $result;
                include 'app/views/products/add.php'; // Đường dẫn đến file form sản phẩm
            } else {
                // Không có lỗi, chuyển hướng ve trang chu hoac trang danh sach
                header('Location: /php');
            }
        }
        
    }
    function uploadImage($file) {
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

    public function detail($id){

        $product = $this->productModel->getProductById($id);

        if ($product) {
            include_once 'app/views/products/detail.php';
        } else {
            include_once 'app/views/share/not-found.php';
        }
    }

    public function edit($id){

        $product = $this->productModel->getProductById($id);

        // var_dump($product);
        // die();

        if ($product) {
            include_once 'app/views/products/edit.php';
        } else {
            include_once 'app/views/share/not-found.php';
        }
    }

    // update
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
    
            // Kiểm tra xem sản phẩm có tồn tại không
            $product = $this->productModel->getProductById($id);
            if (!$product) {
                include_once 'app/views/share/not-found.php';
                return;
            }
    
            // Xử lý tải lên hình ảnh đại diện
            if (isset($_FILES["image"])) {
                $uploadResult = $this->uploadImage($_FILES["image"]);
                if ($uploadResult) {
                    // Lưu đường dẫn của hình ảnh đại diện vào CSDL
                    $result = $this->productModel->updateProduct($id, $name, $description, $price, $uploadResult);
                } else {
                    // Lỗi tải lên
                    // Bạn có thể xử lý lỗi ở đây nếu cần thiết
                }
            } else {
                // Nếu không có hình ảnh mới được tải lên, chỉ cập nhật thông tin sản phẩm
                $result = $this->productModel->updateProduct($id, $name, $description, $price);
            }
    
            if (is_array($result)) {
                // Có lỗi, hiển thị lại form với thông báo lỗi
                $errors = $result;
                include 'app/views/products/edit.php'; // Đường dẫn đến file form sửa sản phẩm
            } else {
                // Không có lỗi, chuyển hướng về trang chi tiết sản phẩm
                header("Location: /php/product/detail/$id");
            }
        }
    }

    //xóa
    public function delete($id) {

        // if (!SessionHelper::isMod()) {
        //     // Nếu không phải mod, chuyển hướng hoặc hiển thị thông báo lỗi
        //     header ('Location: /buoi4php/account/login');
        //     return;
        // }
        // Kiểm tra xem sản phẩm có tồn tại không
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            include_once 'app/views/share/not-found.php';
            return;
        }
    
        // Thực hiện xóa sản phẩm
        $result = $this->productModel->deleteProduct($id);
    
        if ($result) {
            // Nếu xóa thành công, chuyển hướng về trang danh sách sản phẩm
            header("Location: /buoi4php");
        } else {
            // Nếu có lỗi, hiển thị thông báo lỗi
            echo "Xóa sản phẩm không thành công.";
        }
    }
    public function search() {
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 2;
            
            // Số sản phẩm trên mỗi trang
            $itemsPerPage = 6;
            
            // Tính toán vị trí bắt đầu của kết quả truy vấn
            $start = ($currentPage - 1) * $itemsPerPage;
    
            // Gọi phương thức từ ProductModel để tìm kiếm sản phẩm với phân trang
            $searchResult = $this->productModel->searchProductsWithPagination($keyword, $start, $itemsPerPage);
    
            // Pass dữ liệu vào view và hiển thị
            include_once 'app/views/products/search.php';
        } else {
            header('Location: /php');
        }
    }
    
}