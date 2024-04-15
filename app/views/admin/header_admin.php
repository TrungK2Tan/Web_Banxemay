<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TRANG ADMIN</title>
    <!-- Bootstrap Styles-->
    <link href="/php/app/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="/php/app/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="/php/app/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="/php/app/assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/php/admin/"><i class="fa fa-gear"></i> <strong>TRANG CHỦ</strong></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-user">
                    <?php if(isset($_SESSION['username'])){
                         echo "<li ><i class='fa fa-user fa-fw'></i>".$_SESSION['username']."</li>";
                         echo "<li><a href='/php/account/logout'> <i class='fa fa-sign-out fa-fw'></i>Logout</a>";
                    }?>
                    </ul>
                </li>
            </ul>
        </nav>
        <nav class="navbar-default navbar-side" role="navigation">
            <div id="sideNav" href=""><i class="fa fa-caret-right"></i></div>
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu" href="index"><i class="fa fa-dashboard"></i> Quản lý sản phẩm</a>
                    </li>
                    <li>
                        <a href="order"><i class="fa fa-desktop"></i>Quản lý đơn hàng</a>
                    </li>
                    <li>
                        <a href="/php/account/AccountManagement"><i class="fa fa-desktop"></i> Quản lý tài khoản</a>
                    </li>
                </ul>

            </div>

        </nav>