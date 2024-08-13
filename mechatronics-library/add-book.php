<?php
session_start();

# If the admin is logged in
if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {

    # Database Connection File
    include "db_conn.php";

    # Category helper function
    include "php/func-category.php";
    $categories = get_all_categories($conn);

    # Year helper function
    include "php/func-year.php";
    $years = get_all_year($conn);

    if (isset($_GET['title'])) {
        $title = $_GET['title'];
    } else $title = '';

    if (isset($_GET['desc'])) {
        $desc = $_GET['desc'];
    } else $desc = '';

    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
    } else $category_id = 0;

    if (isset($_GET['year_id'])) {
        $year_id = $_GET['year_id'];
    } else $year_id = 0;

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Book</title>

        <!-- bootstrap 5 CDN-->
        <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
        <!-- bootstrap 5 Js bundle CDN-->
        <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" href="css/add-book.css">
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
                                <a class="nav-link mx-lg-2 active" href="add-book.php">Add Book</a>
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
        <div class="book mt-3">
            <form action="php/add-book.php" method="post" enctype="multipart/form-data" class="add_book">
                <h1 class="text-white">
                    Add New Book
                </h1>
                <?php if (isset($_GET['error'])) { ?>
                    <main class="alert">
                        <div class="alert_error" role="alert">
                            <?= htmlspecialchars($_GET['error']); ?>
                        </div>
                    </main>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                    <main class="alert">
                        <div class="alert_success" role="alert">
                            <?= htmlspecialchars($_GET['success']); ?>
                        </div>
                    </main>
                <?php } ?>
                <div class="mb-3">
                    <label class="form-label">
                        Title
                    </label>
                    <input type="text" class="form-control" value="<?= $title ?>" name="book_title">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Description
                    </label>
                    <input type="text" class="form-control" value="<?= $desc ?>" name="book_description">
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
                        } else {
                            foreach ($years as $year) {
                                if ($year_id == $year['id']) { ?>
                                    <option selected value="<?= $year['id'] ?>">
                                        <?= $year['name'] ?>
                                    </option>
                                <?php } else { ?>
                                    <option value="<?= $year['id'] ?>">
                                        <?= $year['name'] ?>
                                    </option>
                        <?php }
                            }
                        } ?>
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
                        } else {
                            foreach ($categories as $category) {
                                if ($category_id == $category['id']) { ?>
                                    <option selected value="<?= $category['id'] ?>">
                                        <?= $category['name'] ?>
                                    </option>
                                <?php } else { ?>
                                    <option value="<?= $category['id'] ?>">
                                        <?= $category['name'] ?>
                                    </option>
                        <?php }
                            }
                        } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Book Cover
                    </label>
                    <input type="file" class="custom" name="book_cover">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        File
                    </label>
                    <input type="file" class="custom" name="file">
                </div>

                <button type="submit" class="btn">
                    Add Book</button>
            </form>
        </div>
    </body>

    </html>
<?php } else {
    header("Location: login.php");
    exit;
} ?>