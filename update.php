<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

//Xu ly method GET
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['pro_id'])) {
    $pro_id = $_GET['pro_id'];
    // echo 'Pro id: ' . $pro_id;

    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM product WHERE pro_id = ?');
    $stmt->execute([$pro_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Product doesn\'t exist with that ID!');
    }
}

if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $pro_id = isset($_POST['pro_id']) ? $_POST['pro_id'] : '';
    $pro_name = isset($_POST['pro_name']) ? $_POST['pro_name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $cate_id = isset($_POST['cate_id']) ? $_POST['cate_id'] : '';
    $url_image = isset($_POST['image']) ? $_POST['image'] : '';
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
                $url_image = $target_file;
            }
        }
    }
    //Add data into database
    $stmt = $pdo->prepare('UPDATE product set pro_name = ?, price = ?, quantity = ?,
    description = ?, cate_id = ?, image = ? where pro_id = ?');
    $stmt->execute(
        array($pro_name, $price, $quantity, $description, $cate_id,  $url_image, $pro_id)
    );
    // Output message
    $msg = 'Upate Successfully!';
    header('location: read.php');
}
?>
<?= template_header('Read') ?>

<div class="content update">
    <h2>Update Product #<?= $product['pro_id'] ?></h2>
    <form action="update.php" method="post" enctype='multipart/form-data'>

        <label for="pro_name">Product Name</label>
        <input type="text" name="pro_name" placeholder="" value="<?= $product['pro_name'] ?>" id="pro_name">

        <label for="price">Price</label>
        <input type="number" name="price" placeholder="" value="<?= $product['price'] ?>" id="price">

        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" placeholder="" value="<?= $product['quantity'] ?>" id="quantity">

        <label for="description">Description</label>
        <input type="text" name="description" placeholder="" value="<?= $product['description'] ?>" id="description">

        <label for="cate_id">Category ID</label>
        <input type="number" name="cate_id" placeholder="" value="<?= $product['cate_id'] ?>" id="cate_id">

        <label for="image">Image </label>
        <input type='file' name='files[]' multiple />

        <div><img src="<?= $product['image'] ?>" title="<?= $product['image'] ?>" width='100' height='100'></div>

        <input type="text" name="pro_id" placeholder="" value="<?= $product['pro_id'] ?>" id="pro_id" hidden>
        <input type="text" name="image" placeholder="" value="<?= $product['image'] ?>" id="image" hidden>

        <input type="submit" value="Update">
    </form>
    <?php if ($msg) : ?>
    <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>