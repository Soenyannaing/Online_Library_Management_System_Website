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

    # Year helper function
    include "php/func-year.php";
    $years = get_all_year($conn);

    # Category helper function
    include "php/func-category.php";
    $categories = get_all_categories($conn);

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

        <link rel="stylesheet" href="css/allbook.css">
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/background.css">
    </head>

    <body>
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
                            foreach ($books as $book) {
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
    </body>

    </html>
<?php } else {
    header("Location: login.php");
    exit;
} ?>