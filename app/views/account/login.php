
<?php
include_once 'app/views/share/header.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin thanh toán</title>
    <!-- Sử dụng Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Sử dụng thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/php/app/css/styles.css">

</head>

<body>
<div class="row">
    <?php if (isset($errors)) {
        echo "<ul>";
        foreach ($errors as $err) {
            echo "<li class='text-danger'>$err</li>";
        }
        echo "</ul>";
    }
    ?>
    <form action="/php/account/checklogin" method="post">
        <div class="form-group">
            <label for="email">Email: </label>
            <input type="email" class="form-control" name="email">
        </div>

        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" class="form-control" name="password">
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>

</html>


<?php
include_once 'app/views/share/footer.php'
?>