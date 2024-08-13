<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {
    
        # If book ID is not set
        if (!isset($_GET['id'])) {
            #Redirect to admin.php page
            header("Location: admin.php");
            exit;
        }
    
        $id = $_GET['id'];

    # Database Connection File
    include "db_conn.php";

    # Book helper function
	include "php/func-book.php";
    $book = get_book($conn, $id);

    # If the ID is invalid
    if ($book == 0) {
    	#Redirect to admin.php page
        header("Location: admin.php");
        exit;
    }

    # Category helper function
	include "php/func-category.php";
    $categories = get_all_categories($conn);

    # author helper function
	include "php/func-year.php";
    $years = get_all_year($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/edit-book.css">
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
                            <a class="nav-link mx-lg-2 active" href="add-year.php">Add Year</a>
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
<div class="book mt-3">
    <form action="php/edit-book.php"
            method="post"
            enctype="multipart/form-data" 
            class="add_book">
            <h1 class="text-white">
                Add New Book
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
                    Title
                    </label>
                <input type="text" 
		           hidden
		           value="<?=$book['id']?>" 
		           name="book_id">

		        <input type="text" 
		           class="form-control"
		           value="<?=$book['title']?>" 
		           name="book_title">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Description
                    </label>
                <input type="text" 
                    class="form-control" 
                    value="<?=$book['description']?>"
                    name="book_description">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Year
                    </label>
                <select name="book_year">
                        <option value="0">
                            Select year
                        </option>
                        <?php 
                        if ($years == 0) {
                            # Do nothing!
                        }else{
                        foreach ($years as $year) { 
                            if ($book['year_id'] == $year['id']) { ?>
                            <option 
                                selected
                                value="<?=$year['id']?>">
                                <?=$year['name']?>
                            </option>
                            <?php }else{ ?>
                            <option
                                value="<?=$year['id']?>">
                                <?=$year['name']?>
                            </option>
                    <?php }} } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Category
                </label>
                <select name="book_category">
                        <option value="0">
                            Select category
                        </option>
                        <?php 
                        if ($categories == 0) {
                            # Do nothing!
                        }else{
                        foreach ($categories as $category) { 
                            if ($book['category_id'] == $category['id']) { ?>
                            <option 
                            selected
                            value="<?=$category['id']?>">
                            <?=$category['name']?>
                            </option>
                            <?php }else{ ?>
                            <option
                                 value="<?=$category['id']?>">
                                <?=$category['name']?>
                            </option>
                    <?php }} } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Cover
                    </label>
                <input type="file" 
		           class="custom" 
		           name="book_cover">

		        <input type="text" 
		           hidden
		           value="<?=$book['cover']?>" 
		           name="current_cover">
                <a href="uploads/cover/<?=$book['cover']?>"
		            class="link-dark">Current Cover</a>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    File
                    </label>
                <input type="file" 
                    class="custom" 
                    name="file">
                <input type="text" 
		                hidden
		                value="<?=$book['file']?>" 
		                name="current_file">

                <a href="uploads/files/<?=$book['file']?>"
                class="link-dark">Current File</a>

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
