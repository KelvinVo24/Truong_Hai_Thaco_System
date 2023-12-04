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

    $stmt = $dbh->prepare('select * from userdata');
    $stmt->execute();
    $imagelist = $stmt->fetchAll();

    foreach ($imagelist as $Image) {
    ?>
        <img src="<?= $Image['Image'] ?>" title="<?= $Image['Image'] ?>" width='100' height='100'>
    <?php
    }
    ?>
</body>

</html>