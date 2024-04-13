<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web bán hàng</title>

    <!-- Sử dụng Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href=".../app/css/styles.css">
    <!-- Kết nối với thư viện Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header class="text-white text-center " style="display:flex;background-color:#fa5230">

        <img src="app/image/logo.png" />
        <h1 class="text-white text-center py-4" style="padding :10px">Xe Máy</h1>
        <div style="display: flex;margin-bottom: 30px;">
            <input placeholder="Search ..." class="form-control"
                style="width: 600px; margin-top: 36px;margin-left: 100px;">
            <button class="btn btn-light" style="margin-top: 36px; margin-left: 10px"><i class="fas fa-search"></i>
            </button>
            <a class="nav-link text-white" href="/php/shoppingcart" style="margin-top: 36px; margin-left: 10px">
                <i class="fas fa-shopping-cart" style="font-size: 19px;margin-top: 12px;"></i>
            </a>
        </div>
        <?php

        include_once 'app/views/share/auth.php'
            ?>

    </header>

    <!-- Menu điều hướng sử dụng Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark"
        style="background-color: #fa5230;margin-top: -30px;padding-bottom: 0;">
        <div class="container">
            <a class="navbar-brand" href="/php">Trang Chủ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item navbar-brand">
                        <a class="nav-link" href="/php">Sản Phẩm</a>
                    </li>
                    <li class="nav-item navbar-brand">
                        <a class="nav-link" href="#">Liên Hệ</a>
                    </li>
                    <?php
                    if (SessionHelper::isLoggedIn()) {
                        if ($_SESSION['role'] == 1) {
                            echo '<li class="nav-item navbar-brand">
                                <a class="nav-link" href="product/add">Thêm mới</a>
                            </li>';
                        }
                    }
                    ?>

                    <li class="nav-item navbar-brand">
                        <a class="nav-link" href="shoppingcart/orderHistory">Đơn đã đặt</a>
                    </li>


                    <li class="nav-item">

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <!-- Danh sách sản phẩm -->
            <div class="col-md-9">