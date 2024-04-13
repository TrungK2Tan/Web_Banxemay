<?php
include_once 'app/controllers/ProductController.php'; // Import ProductController để sử dụng các phương thức của nó
include_once 'app/controllers/AccountController.php'; // Import ProductController để sử dụng các phương thức của nó
include_once 'app/models/OrderModel.php'; // Import ProductController để sử dụng các phương thức của nó
class ShoppingCartController
{

    private $productController;
    private $db; // Thêm biến $db vào đây

    public function __construct($db)
    {
        $this->db = $db;
        $this->productController = new ProductController();
    }
    public function index()
    {
        // Kiểm tra xem session đã được bắt đầu chưa
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Bắt đầu session nếu chưa được bắt đầu
        }

        // Lấy danh sách sản phẩm từ giỏ hàng nếu có
        $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

        // Array to store product information
        $products = [];

        // Retrieve product information for each item in the cart
        foreach ($cartItems as $productId => $quantity) {
            $product = $this->productController->getProductById($productId);
            if ($product) {
                // Assuming $product is an object, access its properties using -> notation
                $products[$productId] = [
                    'name' => $product->name, // Accessing name property of $product object
                    'price' => $product->price, // Accessing price property of $product object
                    'quantity' => $quantity,
                    'total' => $product->price * $quantity // Tính tổng giá của sản phẩm trong giỏ hàng
                ];
            }
        }

        // Calculate total price
        $totalPrice = array_sum(array_column($products, 'total'));

        // Hiển thị trang giỏ hàng
        include_once 'app/views/cart/index.php';
    }

    // Action để thêm sản phẩm vào giỏ hàng
    public function addToCart($productId)
    {
        // Kiểm tra xem session đã được bắt đầu chưa
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Bắt đầu session nếu chưa được bắt đầu
        }

        // Kiểm tra xem giỏ hàng đã tồn tại trong session chưa, nếu chưa thì tạo mới
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Thêm sản phẩm vào giỏ hàng
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        } else {
            $_SESSION['cart'][$productId] = 1; // Thêm sản phẩm vào giỏ hàng với số lượng là 1
        }

        // Trả về trạng thái thành công (200 OK)
        http_response_code(200);
    }

    public function removeCartItem($productId)
    {
        // Kiểm tra xem session đã được bắt đầu chưa
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Bắt đầu session nếu chưa được bắt đầu
        }

        // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
        if (isset($_SESSION['cart'][$productId])) {
            // Xóa sản phẩm khỏi giỏ hàng
            unset($_SESSION['cart'][$productId]);
            // Chuyển hướng về trang giỏ hàng sau khi xóa
            header('Location: /php/shoppingcart'); // Điều hướng về trang giỏ hàng
            exit; // Kết thúc script sau khi chuyển hướng
        } else {
            // Xử lý khi sản phẩm không tồn tại trong giỏ hàng
            echo "Sản phẩm không tồn tại trong giỏ hàng.";
        }
    }

    private function calculateTotalPrice($cartItems)
    {
        $totalPrice = 0;
        foreach ($cartItems as $productId => $quantity) {
            // Lấy giá sản phẩm từ giỏ hàng
            $product = $this->productController->getProductById($productId);
            if ($product) {
                $productPrice = $product->price;
                $totalPrice += $productPrice * $quantity;
            }
        }
        return $totalPrice;
    }


    public function checkout()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['username'])) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            header('Location: /php/account/login');
            exit; // Dừng thực thi script tiếp theo
        }

        // Kiểm tra giỏ hàng không được trống
        if (empty($_SESSION['cart'])) {
            // Nếu giỏ hàng trống, chuyển hướng đến trang mua sắm
            header('Location: /php/');
            exit;
        }

        // Kiểm tra xem người dùng đã nhập thông tin địa chỉ và số điện thoại chưa
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';

            // Kiểm tra xem thông tin đã được nhập đầy đủ chưa
            if (!empty($address) && !empty($phone)) {
                // Lấy thông tin người dùng từ session hoặc cơ sở dữ liệu
                $accountId = $_SESSION['accountId']; // Giả sử đã có biến accountId lưu trữ id của người dùng đăng nhập

                // Tạo một đối tượng OrderModel với kết nối cơ sở dữ liệu
                $orderModel = new OrderModel($this->db);

                // Tạo đơn hàng mới
                $orderDate = date('Y-m-d H:i:s'); // Lấy ngày hiện tại
                $totalPrice = $this->calculateTotalPrice($_SESSION['cart']); // Tính tổng giá trị đơn hàng

                // Lưu thông tin đơn hàng vào bảng Order
                $orderId = $orderModel->createOrder($orderDate, $address, $phone, $totalPrice, $accountId);

                // Lưu chi tiết đơn hàng vào bảng OrderDetail
                foreach ($_SESSION['cart'] as $productId => $quantity) {
                    $orderModel->createOrderDetail($orderId, $productId, $quantity); // Corrected line
                }

                // Xóa giỏ hàng sau khi thanh toán thành công
                unset($_SESSION['cart']);

                // Chuyển hướng đến trang thông báo thanh toán thành công hoặc trang lịch sử đơn hàng
                header('Location: /php/app/views/cart/success.php'); // Đây là URL của trang thông báo thanh toán thành công
                exit;
            } else {
                // Nếu thông tin không đầy đủ, hiển thị form lại với thông báo lỗi
                $errorMessage = "Vui lòng nhập địa chỉ và số điện thoại.";
            }
        }

        // Hiển thị form nhập thông tin địa chỉ và số điện thoại
        include_once 'app/views/cart/pay_form.php';
    }
    public function orderHistory()
{
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['username'])) {
        // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
        header('Location: /php/account/login');
        exit; // Dừng thực thi script tiếp theo
    }

    // Lấy thông tin người dùng từ session hoặc cơ sở dữ liệu
    $accountId = $_SESSION['accountId']; // Giả sử đã có biến accountId lưu trữ id của người dùng đăng nhập

    // Tạo một đối tượng OrderModel với kết nối cơ sở dữ liệu
    $orderModel = new OrderModel($this->db);

    // Lấy lịch sử đơn hàng cho người dùng hiện tại
    $orderHistory = $orderModel->getOrderHistory($accountId);

    // Hiển thị trang lịch sử đơn hàng
    include_once 'app/views/cart/order_history.php';
}

    



}

?>