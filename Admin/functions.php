<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'Abc12345';
    $DATABASE_NAME = 'signuplogin';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="/pdo_Signup/css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<img src="/pdo_Signup/img/LOGO_THACO.png" class="logo">
			<a href="/pdo_Signup/Admin/index.php"><i class="fas fa-home"></i>Home</a>
			<a href="/pdo_Signup/Admin/read.php"><i class="fa-solid fa-car"></i>Products</a>
			<a href="/pdo_Signup/User/read.php"><i class="fas fa-address-book"></i>Admins</a>
			<div class="nav">
				<a href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
			</div>

    	</div>
    </nav>
EOT;
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>