<?php
session_start();

# If the admin is logged in
if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {

    # Database Connection File
    include "db_conn.php";

    # Book helper function
    include "php/func-book.php";
    $books = get_all_books($conn);
    $bookpages = get_all_book_pages($conn);

    # Year helper function
    include "php/func-year.php";
    $years = get_all_year($conn);

    # Category helper function
    include "php/func-category.php";
    $categories = get_all_categories($conn);

    # Teacher helper function
    include "php/func-teacher.php";
    $teachers = get_all_teachers($conn);
    $teacherpages = get_all_teacher_pages($conn);

    # Activity helper function
    include "php//func-activity.php";
    $activities = get_all_activities($conn);

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ADMIN</title>

        <!-- bootstrap 5 CDN-->
        <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
        <!-- bootstrap 5 Js bundle CDN-->
        <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
        
        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/background.css">
    </head>

    <body>
        <!-- Navbar-->
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
        <?php if ($books == 0) { ?>
            <div class="alert alert-warning 
                    text-center p-5" role="alert">
                <img src="img/no_data.jpg" width="100">
                <br>
                There is no book in the database
            </div>
        <?php } else { ?>
            <!-- All books -->
            <div class="table_book mt-3">
                <section class="table_book_header">
                    <h4>All Books</h4>
                    <a href="allbook.php">See All</a>
                </section>
                <section class="table_book_body">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Year</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($bookpages as $book) {
                                $i++;
                            ?>
                                <tr class="table_book_text">
                                    <td><?= $i ?></td>
                                    <td class="table_text_title">
                                        <img src="uploads/cover/<?= $book['cover'] ?>">
                                        <a class="title_link link-dark" href="uploads/files/<?= $book['file'] ?>">
                                            <?= $book['title'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($years == 0) {
                                            echo "Undefined";
                                        } else {

                                            foreach ($years as $year) {
                                                if ($year['id'] == $book['year_id']) {
                                                    echo $year['name'];
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?= $book['description'] ?></td>
                                    <td>
                                        <?php if ($categories == 0) {
                                            echo "Undefined";
                                        } else {

                                            foreach ($categories as $category) {
                                                if ($category['id'] == $book['category_id']) {
                                                    echo $category['name'];
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class="edit_delete">
                                        <a href="edit-book.php?id=<?= $book['id'] ?>" class="btn_edit">Edit</a>
                                        <a href="php/delete-book.php?id=<?= $book['id'] ?>" class="btn_delete">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>
            </div>
        <?php } ?>

        <?php if ($teachers == 0) { ?>
            <div class="no_data" role="alert">
                <img src="img/no_data.jpg">
                <br>
                There is no teacher info in the database
            </div>
        <?php } else { ?>
            <div class="table_teacher">
                <section class="table_teacher_header">
                    <h4>Teachers Information</h4>
                    <a href="allteacher.php">See All</a>
                </section>
                <section class="table_teacher_body">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Role</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $b = 0;
                            foreach ($teacherpages as $teacher) {
                                $b++;
                            ?>
                                <tr class="table_teacher_text">
                                    <td><?= $b ?></td>
                                    <td class="table_text_profile">
                                        <img src="uploads/profile/<?= $teacher['profile'] ?>">
                                        <?= $teacher['name'] ?>
                                    </td>
                                    <td>
                                        <?= $teacher['age'] ?>
                                    </td>
                                    <td>
                                        <?= $teacher['role'] ?>
                                    </td>
                                    <td><?= $teacher['description'] ?></td>
                                    <td class="edit_delete">
                                        <a href="edit-teacher.php?id=<?= $teacher['id'] ?>" class="btn_edit">Edit</a>
                                        <a href="php/delete-teacher.php?id=<?= $teacher['id'] ?>" class="btn_delete">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>
            </div>
        <?php } ?>
        <div class="two_rows">
            <?php if ($years == 0) { ?>
                <div class="alert alert-warning 
                    text-center p-5" role="alert">
                    <img src="img/no_data.jpg" width="100">
                    <br>
                    There is no year class in the database
                </div>
            <?php } else { ?>
                <!-- List of all Years -->
                <div class="table_year">
                    <section class="table_year_header">
                        <h4>All Years</h4>
                    </section>
                    <section class="table_year_body">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $k = 0;
                                foreach ($years as $year) {
                                    $k++;
                                ?>
                                    <tr>
                                        <td><?= $k ?></td>
                                        <td><?= $year['name'] ?></td>
                                        <td class="edit_delete">
                                            <a href="edit-year.php?id=<?= $year['id'] ?>" class="btn_edit">
                                                Edit</a>

                                            <a href="php/delete-year.php?id=<?= $year['id'] ?>" class="btn_delete">
                                                Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            <?php } ?>

            <?php if ($categories == 0) { ?>
                <div class="alert alert-warning 
                    text-center p-5" role="alert">
                    <img src="img/no_data.jpg" width="100">
                    <br>
                    There is no category in the database
                </div>
            <?php } else { ?>

                <!-- List of all categories -->
                <div class="table_category">
                    <section class="table_category_header">
                        <h4>All Categories</h4>
                    </section>
                    <section class="table_category_body">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $j = 0;
                                foreach ($categories as $category) {
                                    $j++;
                                ?>
                                    <tr>
                                        <td><?= $j ?></td>
                                        <td><?= $category['name'] ?></td>
                                        <td class="edit_delete">
                                            <a href="edit-category.php?id=<?= $category['id'] ?>" class="btn_edit">
                                                Edit</a>

                                            <a href="php/delete-category.php?id=<?= $category['id'] ?>" class="btn_delete">
                                                Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            <?php } ?>
        </div>

        <?php if ($activities == 0) { ?>
            <div class="no_data" role="alert">
                <img src="img/no_data.jpg">
                <br>
                There is no activity in the database
            </div>
        <?php } else { ?>
            <!-- Activity -->
            <div class="table_activity">
                <section class="table_activity_header">
                    <h4>Major Activity</h4>
                </section>
                <section class="table_activity_body">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $b = 0;
                            foreach ($activities as $activity) {
                                $b++;
                            ?>
                                <tr class="table_activity_text">
                                    <td><?= $b ?></td>
                                    <td class="table_text_profile">
                                        <img src="uploads/photo/<?= $activity['photo'] ?>">
                                        <?= $activity['title'] ?>
                                    </td>
                                    <td><?= $activity['description'] ?></td>
                                    <td class="edit_delete">
                                        <a href="edit-activity.php?id=<?= $activity['id'] ?>" class="btn_edit">Edit</a>
                                        <a href="php/delete-activity.php?id=<?= $activity['id'] ?>" class="btn_delete">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>
            </div>
        <?php } ?>
    </body>

    </html>
<?php } else {
    header("Location: login.php");
    exit;
} ?>