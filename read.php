<?php
include 'functions.php'; 
// Connect to MySQL database
$pdo = pdo_connect_mysql(); 
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM product ORDER BY pro_id DESC LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$products = $stmt->fetchAll(PDO::FETCH_ASSOC); //Object = fetchAll => Đưa toàn bộ dữ liệu vào đối tượng products
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM product')->fetchColumn(); //Số lượng sản phẩm
?>
<?=template_header('Read')?>

<div class="content read">
	<h2>Read Products</h2>
	<a href="create.php" class="create-contact">Create Product</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Description</td>
                <td>Category</td>
                <td>Image</td>
                <td>Functions</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?> 
                <!-- Lấy vòng lặp -->
            <tr>
                <td><?=$product['pro_id']?></td>
                <td><?=$product['pro_name']?></td>
                <td><?=$product['price']?></td>
                <td><?=$product['quantity']?></td>
                <td><?=$product['description']?></td>
                <td><?=$product['cate_id']?></td>
                <td><img src="<?= $product['image'] ?>" title="<?= $product['image'] ?>" width='100' height='100'></td>

                <td class="actions">
                    <a href="update.php?pro_id=<?=$product['pro_id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?pro_id=<?=$product['pro_id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $product): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>