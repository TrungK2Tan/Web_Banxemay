
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

    <h1>
        <?php if(isset($errors))
                var_dump($errors);
            ?>
    </h1>

    <form action="/php/admin/update/<?=$product->id?>" method="post" enctype="multipart/form-data">


        <input type="hidden" name="id" value="<?=$product->id?>">

        <div class="form-group">
            <label for="name">Name </label>
            <input type="text" class="form-control" id="name" name="name" value="<?=$product->name?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description"
                value="<?=$product->description?>">
        </div>
        <div class="form-group">
            <label for="price">Price</label>

            <input type="number" class="form-control" id="price" name="price" value="<?=$product->price?>">
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <img src="/php/<?=$product->image?>" />
            <br>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>

</html>


<?php
include_once 'app/views/share/footer.php'
?>