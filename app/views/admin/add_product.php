<?php include_once 'app/views/admin/header_admin.php'; ?>
<div id="page-wrapper">
    <div id="page-inner">
<div class="row">
    <form action="/php/admin/save" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Price" required>
        </div>
        <div class="form-group">
            <label for="price">Category:</label>
            <input type="number" class="form-control" id="category" name="category" placeholder="category" required>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
    </div>
</div>
</body>
</html>
