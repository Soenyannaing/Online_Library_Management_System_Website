<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

    # If ac$activity ID is not set
      if (!isset($_GET['id'])) {
        #Redirect to admin.php page
        header("Location: admin.php");
        exit;
    }
    
        $id = $_GET['id'];

    # Database Connection File
    include "db_conn.php";

    # Activity helper function
	include "php/func-activity.php";
    $activity = get_activity($conn, $id);

    # If the ID is invalid
    if ($activity == 0) {
    	#Redirect to admin.php page
        header("Location: admin.php");
        exit;
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Activity</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/edit-teacher.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/background.css">

</head>
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
                            <a class="nav-link mx-lg-2" href="add-category.php">Add Category</a>
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
<div class="teacher mt-3">
    <form action="php/edit-activity.php"
            method="post"
            enctype="multipart/form-data" 
            class="add_teacher">
            <h1 class="text-white">
                Edit Activity
            </h1>
            <?php if (isset($_GET['error'])) { ?>
                <main class="alert">
                    <div class="alert_error" role="alert">
                        <?=htmlspecialchars($_GET['error']); ?>
                    </div>
                </main>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <main class="alert">
                    <div class="alert_success" role="alert">
                        <?=htmlspecialchars($_GET['success']); ?>
                    </div>
                </main>
            <?php } ?>

            <div class="mb-3">
                <label class="form-label">
                    <Title></Title>
                </label>
                <input type="text" 
		           hidden
		           value="<?=$activity['id']?>" 
		           name="activity_id">
                <input type="text" 
                    class="form-control"
                    value="<?=$activity['title']?>" 
                    name="activity_title">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Description
                </label>
                <input type="text" 
                    class="form-control" 
                    value="<?=$activity['description']?>"
                    name="activity_description">
            </div>

            <div class="mb-3 ">
                <label class="form-label">
                    Activity Photo
                </label>
                <input type="file" 
                    class="custom"
                    name="activity_photo">
                
                <input type="text" 
		           hidden
		           value="<?=$activity['photo']?>" 
		           name="current_photo">
                <a href="uploads/photo/<?=$activity['photo']?>"
		            class="link-dark">Current Photo</a>
            </div>

            <button type="submit" 
                    class="btn">
                    Update</button>
    </form>
</div>
</body>
</html>
<?php }else{
  header("Location: login.php");
  exit;
} ?>