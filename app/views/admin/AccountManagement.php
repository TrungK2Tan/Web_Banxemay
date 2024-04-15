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
                    <input placeholder="search tài khoản" />
                    <button><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Danh sách tài khoản
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID tài khoản</th>
                                        <th>Email</th>
                                        <th>Tên</th>
                                        <th>Quyền</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo isset($user['id']) ? $user['id'] : ''; ?></td>
                                        <td><?php echo isset($user['name']) ? $user['name'] : ''; ?></td>
                                        <td><?php echo isset($user['email']) ? $user['email'] : ''; ?></td>
                                        <td><?php echo isset($user['role_id']) ? $user['role_id'] : ''; ?></td>
                                        <td>
                                            <a href="/php/admin/user/edit/<?php echo isset($user['id']) ? $user['id'] : ''; ?>">Edit</a>
                                            <a href="/php/admin/user/delete/<?php echo isset($user['id']) ? $user['id'] : ''; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No users found.</td>
                                </tr>
                            <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <a href="/php/account/addUser" class="btn btn-success">Thêm tài khoản</a>
            </div>
        </div>
    </div>
</div>