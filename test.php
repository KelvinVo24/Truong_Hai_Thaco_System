<?php
session_start();
require_once "config.php";
try {
    if (isset($_POST["login"])) {
        if (empty($_POST["UserName"]) || empty($_POST["LoginPassword"])) {
            $message = '<label>All fields are required</label>';
        } else {
            $query = "SELECT * FROM userdata WHERE UserName = :UserName AND LoginPassword = :LoginPassword";
            $statement = $dbh->prepare($query);
            $statement->execute(
                array(
                    'UserName'     =>     $_POST["UserName"],
                    'LoginPassword'     =>     $_POST["LoginPassword"]
                )
            );
            $count = $statement->rowCount();
            if ($count > 0) {
                $_SESSION["UserName"] = $_POST["UserName"];
                header("location:index.php");
                exit();
            } else {
                $message = '<label>Wrong Data</label>';
            }
        }
    }
} catch (PDOException $error) {
    // $message = $error->getMessage();
    $message = 'Login successful!';
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Webslesson Tutorial | PHP Login Script using PDO</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <br />
    <div class="container" style="width:500px;">
        <?php
        if (isset($message)) {
            echo '<label class="text-danger">' . $message . '</label>';
        }
        ?>
        <h3 align="">PHP Login Script using PDO</h3><br />
        <form method="post">
            <label>Username</label>
            <input type="text" name="UserName" class="form-control" />
            <br />
            <label>Password</label>
            <input type="password" name="LoginPassword" class="form-control" />
            <br />
            <input type="submit" name="login" class="btn btn-info" value="Login" />
        </form>
    </div>
    <br />
</body>
</html>