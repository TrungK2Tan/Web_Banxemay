<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Web Bán Hàng</title>

    <!-- Sử dụng Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <header class="bg-success text-white text-center py-4">
        <h1>Trang Web Bán Hàng</h1>
    </header>

    <!-- Menu điều hướng sử dụng Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="#">Trang Chủ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên Hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Nút Thêm mới -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- Form hoặc liên kết để chuyển hướng đến trang thêm mới sản phẩm -->
                <form action="create_product.php" method="post">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Danh sách sản phẩm -->
            <div class="col-md-9">
                <!-- Hiển thị sản phẩm bằng dạng dòng sản phẩm sử dụng Bootstrap Row và Col -->
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <!-- Hiển thị sản phẩm từ mã PHP -->
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="col">
                        <div class="card">
                            <img src="/php/<?php echo $row['image']; ?>" class="card-img-top"
                                alt="<?php echo $row['name']; ?>" style="width: 300px; height: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                                <p class="card-text">Giá: <?php echo $row['price']; ?></p>
                                <form action="editProductForm" method="post" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="submit" value="Sửa">
                                </form>
                                <!-- Nút Xóa -->
                                <form action="deleteProduct" method="post" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="submit" value="Xóa"
                                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="bg-primary text-white p-3">
                    <h5>Social Media</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần footer -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="bg-dark text-white text-center py-4">
                    <h3>Cột 1</h3>
                    <p>Nội dung cột 1.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-dark text-white text-center py-4">
                    <h3>Cột 2</h3>
                    <p>Nội dung cột 2.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-dark text-white text-center py-4">
                    <h3>Cột 3</h3>
                    <p>Nội dung cột 3.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sử dụng Bootstrap JS và Popper.js (cần cài đặt trước khi sử dụng Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>