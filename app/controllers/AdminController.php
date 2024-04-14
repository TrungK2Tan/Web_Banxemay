<?php
require_once 'app/models/ProductModel.php';

class AdminController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        // Establish a database connection and initialize the product model
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        // Check if there's a request to delete a product
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $productId = $_GET['id'];
            $this->deleteProduct($productId);
        }

        // Retrieve all products
        $products = $this->productModel->getAllProducts();

        // Include the index view
        include 'app/views/admin/index.php';
    }

    public function addProduct()
    {
        // Include the add product view
        include 'app/views/admin/add_product.php';
    }

    public function saveProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve product data from the form
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';

            // Logic to handle image upload if needed
            $image = ''; 

            // Create the product
            $result = $this->productModel->createProduct($name, $description, $price, $image);

            if ($result === true) {
                // Product created successfully, redirect to admin index
                header("Location: /php/admin/");
                exit;
            } else {
                // Handle errors
                // You can set an error message here and redirect back to the add product form
            }
        }
    }

    public function deleteProduct($productId)
    {
        // Delete the product
        $result = $this->productModel->deleteProduct($productId);

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
