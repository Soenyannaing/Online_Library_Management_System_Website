<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>

    <!-- bootstrap 5 CDN-->
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- bootstrap 5 Js bundle CDN-->
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="css/add-category.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/background.css">

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand mechatronics me-auto" href="admin.php">Admin</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title mechatronics" id="offcanvasNavbarLabel">Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="add-book.php">Add Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="add-year.php">Add Year</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 active" href="add-category.php">Add Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="add-teacher.php">Add Information</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link mx-lg-2" href="add-activity.php">Add Activity</a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="logout.php" class="logout-button">Logout</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
<div class="category">
    <form action="php/add-category.php" 
            method="post"
            class="add_category">
        <h1 class="text-white">Add Category</h1>
        <?php if (isset($_GET['error'])) { ?>
            <main class="alert">
                <div class="alert_error" role="alert">
                    <?= htmlspecialchars($_GET['error']); ?>
                </div>
            </main>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <main class="alert">
                <div class="alert_success">
                    <?= htmlspecialchars($_GET['success']); ?>
                </div>
            </main>
            <?php } ?>
        <div>
            <label class="form-label">
                Category
            </label>
            <input type="text" 
                class="form-control"
                name="category_name">
        </div>
        <button type="submit" 
                class="btn">Add
        </button>
    </form>
</div>
</div>
</body>
</html>
<?php }else{
  header("Location: login.php");
  exit;
} ?>
