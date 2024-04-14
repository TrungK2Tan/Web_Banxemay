<?php
include_once 'app/views/share/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Bootstrap Styles -->
    <link href="/php/app/assets/css/bootstrap.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form action="/php/admin/updateProduct" method="post">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo $product['description']; ?>">
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>">
            </div>
            <!-- Add other fields as needed -->

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>

<?php
include_once 'app/views/share/footer.php';
?>
