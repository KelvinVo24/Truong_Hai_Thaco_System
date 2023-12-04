<?php
// login_success.php  
session_start();
if (isset($_SESSION["UserName"])) {
    echo '<h3>Login Success, Welcome - ' . $_SESSION["UserName"] . '</h3>';
    echo '<br /><br /><a href="logout.php">Logout</a>';
    header("location: read.php");
} else {
    header("location:pdo_login.php");
}
