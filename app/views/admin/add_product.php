<!DOCTYPE html>
<html>
<head>
    <title>Thêm Sản Phẩm</title>
    <!-- Include các file CSS và JS cần thiết -->
</head>
<body>
    <!-- Form thêm sản phẩm -->
    <h2>Thêm Sản Phẩm</h2>
    <form method="post" action="/php/admin/saveProduct">
        <!-- Trường nhập tên sản phẩm -->
        <label for="name">Tên Sản Phẩm:</label>
        <input type="text" id="name" name="name"><br><br>
        
        <!-- Trường nhập mô tả sản phẩm -->
        <label for="description">Mô Tả:</label><br>
        <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>
        
        <!-- Trường nhập giá sản phẩm -->
        <label for="price">Giá Tiền:</label>
        <input type="number" id="price" name="price"><br><br>
        
        <!-- Trường upload hình ảnh sản phẩm -->
        <label for="image">Hình Ảnh:</label>
        <input type="file" id="image" name="image"><br><br>
        
        <!-- Nút submit để thêm sản phẩm -->
        <input type="submit" name="submit" value="Thêm">
    </form>
</body>
</html>
