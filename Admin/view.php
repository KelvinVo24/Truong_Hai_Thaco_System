<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php

    $stmt = $dbh->prepare('select * from product');
    $stmt->execute();
    $imagelist = $stmt->fetchAll();

    foreach ($imagelist as $image) {
    ?>

        <img src="<?= $image['image'] ?>" title="<?= $image['image'] ?>" width='100' height='100'>
    <?php
    }
    ?>
</body>

</html>