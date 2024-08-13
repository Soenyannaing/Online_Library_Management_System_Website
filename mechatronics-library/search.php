<?php
session_start();

# If search key is not set or empty
// if (!isset($_GET['key']) || empty($_GET['key'])) {
//     header("Location: index.php");
//     exit;
// }
// $key = $_GET['key'];

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
// $books = search_books($conn, $key);

# year helper function
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
    <title>Book Store</title>

    <!-- bootstrap 5 CDN-->
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- bootstrap 5 Js bundle CDN-->
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/main.css">

</head>

<body>
    <?php

    $searchTerm = isset($_GET['key']) ? $_GET['key'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $resultsPerPage = 4;
    $offset = ($page - 1) * $resultsPerPage;

    $sql = "SELECT * FROM books WHERE title LIKE :searchTerm OR description LIKE :searchTerm ORDER bY id DESC LIMIT :offset, :resultsPerPage";
    $stmt = $conn->prepare($sql);
    $searchTermWithWildcards = "%" . $searchTerm . "%";
    $stmt->bindParam(':searchTerm', $searchTermWithWildcards, PDO::PARAM_STR);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':resultsPerPage', $resultsPerPage, PDO::PARAM_INT);
    $stmt->execute();

    $results = $stmt->fetchAll();

    $sqlCount = "SELECT COUNT(*) FROM books WHERE title LIKE :searchTerm OR description LIKE :searchTerm ORDER bY id DESC";
    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->bindParam(':searchTerm', $searchTermWithWildcards, PDO::PARAM_STR);
    $stmtCount->execute();
    $totalResults = $stmtCount->fetchColumn();
    $totalPages = ceil($totalResults / $resultsPerPage);

    ?>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand mechatronics me-auto" href="index.php">Mechatronics</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title mechatronics" id="offcanvasNavbarLabel">Mechatronics</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="library.php">Library</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="teacher-info.php">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2" href="about.php">About</a>
                        </li>
                        <form action="search.php" method="get" class="search_box d-flex">
                            <input class="form-control" name="key" type="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search....." aria-label="Search">
                            <div class="box_btn">
                                <button class="btn" type="submit">
                                    <img src="img/search.png" alt="">
                                </button>
                            </div>
                        </form>
                    </ul>
                </div>
            </div>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <a href="login.php" class="logout-button">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <?php } else { ?>
                <a href="login.php" class="logout-button">Login</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <?php } ?>
        </div>
    </nav>

    <div class="result"><b>Results: <b><?= $searchTerm ?></b>
    </div>

    <div class="d-flex pt-3 all_book_card ">
        <?php if ($results) { ?>
            <div class="pdf-list d-flex flex-wrap">
                <?php foreach ($results as $book) { ?>
                    <div class="book_card">
                        <div class="img_decoration">
                            <img src="uploads/cover/<?= $book['cover'] ?>" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <div class="card-body-text">
                                <p class="card_title">
                                    <?= $book['title'] ?>
                                </p>
                                <p class="card_text">
                                    <?php foreach ($years as $year) {
                                        if ($year['id'] == $book['year_id']) {
                                            echo $year['name'];
                                            break;
                                        }
                                    ?>
                                    <?php } ?>
                                    <br></b>
                                </p>
                            </div>
                            <div class="open_download">
                                <a href="uploads/files/<?= $book['file'] ?>" class="btn_open">Open</a>

                                <a href="uploads/files/<?= $book['file'] ?>" class="btn_download" download="<?= $book['title'] ?>">Download</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning 
                text-center p-5" role="alert">
                <img src="img/no_data.jpg" width="100">
                <br>
                There is no book in the database
            </div>
        <?php } ?>
    </div>
    
    <?php if ($results) { ?>
        <div class="pagination">
            <nav class="pagni">
                <ul>
                    <!-- First Page Button -->
                    <li>
                        <a href="?key=<?php echo urlencode($searchTerm); ?>&page=1" class="<?php echo $page == 1 ? 'disabled' : ''; ?>">
                            First
                        </a>
                    </li>

                    <!-- Previous Page Button -->
                    <li>
                        <a href="?key=<?php echo urlencode($searchTerm); ?>&page=<?php echo max(1, $page - 1); ?>" class="<?php echo $page == 1 ? 'disabled' : ''; ?>">
                            Previous
                        </a>
                    </li>

                    <!-- Page Numbers -->
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li>
                            <a href="?key=<?php echo urlencode($searchTerm); ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next Page Button -->
                    <li>
                        <a href="?key=<?php echo urlencode($searchTerm); ?>&page=<?php echo min($totalPages, $page + 1); ?>" class="<?php echo $page == $totalPages ? 'disabled' : ''; ?>">
                            Next
                        </a>
                    </li>

                    <!-- Last Page Button -->
                    <li>
                        <a href="?key=<?php echo urlencode($searchTerm); ?>&page=<?php echo $totalPages; ?>" class="<?php echo $page == $totalPages ? 'disabled' : ''; ?>">
                            Last
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php } else { ?>

    <?php } ?>
</body>

</html>