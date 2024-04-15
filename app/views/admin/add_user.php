<?php include_once 'app/views/admin/header_admin.php'; ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <h1 class="page-header">
                        Quản lý <small>tài khoản</small>
                    </h1>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <input placeholder="Tìm kiếm tài khoản" class="form-control">
                    <button class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <!-- Phần content của trang addUser -->
                            <h1>Thêm tài khoản</h1>
                            <form method="post" action="/php/account/saveUser">
                                <div class="form-group">
                                    <label for="name">Tên người dùng:</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Mật khẩu:</label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Lưu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>