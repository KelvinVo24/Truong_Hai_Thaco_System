<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

//Xu ly method GET
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // echo 'Pro id: ' . $id;

    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM userdata WHERE id = ?');
    $stmt->execute([$id]);
    $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$userdata) {
        exit('Product doesn\'t exist with that ID!');
    }
}

if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $FullName = isset($_POST['FullName']) ? $_POST['FullName'] : '';
    $UserName = isset($_POST['UserName']) ? $_POST['UserName'] : '';    
    $Role = isset($_POST['Role']) ? $_POST['Role'] : '';
    $UserEmail = isset($_POST['UserEmail']) ? $_POST['UserEmail'] : '';
    $UserMobileNumber = isset($_POST['UserMobileNumber']) ? $_POST['UserMobileNumber'] : '';
    $LoginPassword = isset($_POST['LoginPassword']) ? $_POST['LoginPassword'] : '';
    $url_image = isset($_POST['Image']) ? $_POST['Image'] : '';
    //Upload Image to host
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
        // Valid Image extension
        $valid_extension = array("png", "jpeg", "jpg", "webp");
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
    $stmt = $pdo->prepare('UPDATE userdata set FullName = ?, UserName = ?, Role = ?, UserEmail = ?,
    UserMobileNumber = ?, LoginPassword = ?, Image = ? where id = ?');
    $stmt->execute(
        array($FullName, $UserName, $Role, $UserEmail, $UserMobileNumber, $LoginPassword,  $url_image, $id)
    );
    // Output message
    $msg = 'Upate Successfully!';
    header('location: read.php');
}
?>
<?= template_header('Read') ?>
<link rel="stylesheet" href="/pdo_Signup/css/sb-admin-2.css">
<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
        <i class="fa-solid fa-car"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin <sup>#1</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <!-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> -->

</ul>



<div class="content update">

    <h2>Update Product #<?= $userdata['id'] ?></h2>
    <form action="update.php" method="post" enctype='multipart/form-data'>

        <label for="FullName">Name</label>
        <input type="text" name="FullName" placeholder="" value="<?= $userdata['FullName'] ?>" id="FullName">

        <label for="UserName">Username</label>
        <input type="text" name="UserName" placeholder="" value="<?= $userdata['UserName'] ?>" id="UserName">

        <label for="UserName">Role</label>
        <input type="text" name="Role" placeholder="" value="<?= $userdata['Role'] ?>" id="Role">

        <label for="UserEmail">Email</label>
        <input type="text" name="UserEmail" placeholder="" value="<?= $userdata['UserEmail'] ?>" id="UserEmail">

        <label for="UserMobileNumber">Phone</label>
        <input type="text" name="UserMobileNumber" placeholder="" value="<?= $userdata['UserMobileNumber'] ?>" id="UserMobileNumber">

        <label for="LoginPassword">Password</label>
        <input type="text" name="LoginPassword" placeholder="" value="<?= $userdata['LoginPassword'] ?>" id="LoginPassword">

        <label for="Image">Image </label>
        <input type='file' name='files[]' multiple />

        <div><img src="<?= $userdata['Image'] ?>" title="<?= $userdata['Image'] ?>" width='100' height='100'></div>

        <input type="text" name="id" placeholder="" value="<?= $userdata['id'] ?>" id="id" hidden>
        <input type="text" name="Image" placeholder="" value="<?= $userdata['Image'] ?>" id="Image" hidden>

        <div class="div">
            <input type="submit" value="Update">
        </div>
        
    </form>
    <?php if ($msg) : ?>
    <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>