<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $pro_name = isset($_POST['pro_name']) ? $_POST['pro_name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $cate_id = isset($_POST['cate_id']) ? $_POST['cate_id'] : '';

    //Upload image to host
    // Count total files
    $countfiles = count($_FILES['files']['name']);
    // Loop all files
    for ($i = 0; $i < $countfiles; $i++) {
        // File name
        $filename = $_FILES['files']['name'][$i];
        // Location
        $target_file = './uploads/' . $filename;
        // file extension
        $file_extension = pathinfo(
            $target_file,
            PATHINFO_EXTENSION
        );
        $file_extension = strtolower($file_extension);
        // Valid image extension
        $valid_extension = array("png", "jpeg", "jpg");
        if (in_array($file_extension, $valid_extension)) {
            // Upload file
            if (move_uploaded_file(
                $_FILES['files']['tmp_name'][$i],
                $target_file
            )) {
                //Add data into database
                $stmt = $pdo->prepare('INSERT INTO product(pro_name, price, quantity, description, cate_id, image) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute(
                    array($pro_name, $price, $quantity, $description, $cate_id, $target_file)
                );
                // Output message
                $msg = 'Created Successfully!';
                header('location: read.php');
            }
        }
    }

}
?>
<?= template_header('Create') ?>

<div class="content update">
    <h2>Create Product</h2>
    <form action="create.php" method="post" enctype='multipart/form-data'>
        <label for="pro_name">Product Name</label>
        <input type="text" name="pro_name" placeholder="" id="pro_name">

        <label for="price">Price</label>
        <input type="number" name="price" placeholder="" id="price">

        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" placeholder="" id="quantity">

        <label for="description">Description</label>
        <input type="text" name="description" placeholder="" id="description">

        <label for="cate_id">Category ID</label>
        <input type="number" name="cate_id" placeholder="" id="cate_id">

        <label for="image">Image </label>
        <input type='file' name='files[]' multiple />

        <input type="submit" value="Create">
    </form>
    <?php if ($msg) : ?>
    <p><?= $msg ?></p>
    <?php endif; ?>
</div>
?>
<?= template_footer() ?>