<?php
session_start();

# If not category ID is set
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

# Get category ID from GET request
$id = $_GET['id'];



# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_books_by_category($conn, $id);


# year helper function
include "php/func-year.php";
$years = get_all_year($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);
$current_category = get_category($conn, $id);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>

    <!-- bootstrap 5 CDN-->
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- bootstrap 5 Js bundle CDN-->
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="css/category.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/main.css">


</head>

<body>

    <?php
    // Define the number of books per page
    $booksPerPage = 8;

    // Get the current page from the query string (default to 1 if not set)
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $booksPerPage;

    // Get the category ID from the query string
    $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    try {
        // Prepare the SQL query with pagination
        $stmt = $conn->prepare("SELECT * FROM books WHERE category_id = :categoryId ORDER bY id DESC LIMIT :offset, :limit");
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $booksPerPage, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();
        $bookks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get total number of books for pagination
        $totalStmt = $conn->prepare("SELECT COUNT(*) FROM books WHERE category_id = :categoryId ORDER bY id DESC");
        $totalStmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $totalStmt->execute();
        $totalBooks = $totalStmt->fetchColumn();
        $totalPages = ceil($totalBooks / $booksPerPage);
    } catch (PDOException $e) {
        die("Could not fetch books: " . $e->getMessage());
    }
    ?>

    <!-- Navbar-->
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
                            <input class="form-control" name="key" type="search" placeholder="Search....." aria-label="Search">
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
    <div class="result"><b>Results: <b><?= $current_category['name'] ?></b>
    </div>
    
    <div class="all_book_card">
        <?php if ($bookks == 0) { ?>
            <div class="alert alert-warning 
                text-center p-5" role="alert">
                <img src="img/no_data.png" width="100">
                <br>
                There is no book in the database
            </div>
        <?php } else { ?>
            <div class="pdf-list d-flex flex-wrap">
                <?php foreach ($bookks as $book) { ?>
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
        <?php } ?>
    </div>
    <div class="pagination">
        <nav class="pagni">
            <ul>
                <li>
                    <a href="?id=<?php echo $categoryId; ?>&page=1" class="<?php echo $page == 1 ? 'disabled' : ''; ?>">First</a>
                </li>
                <li>
                    <a href="?id=<?php echo $categoryId; ?>&page=<?php echo $page - 1; ?>" class="<?php echo $page == 1 ? 'disabled' : ''; ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li>
                        <a href="?id=<?php echo $categoryId; ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li>
                    <a href="?id=<?php echo $categoryId; ?>&page=<?php echo $page + 1; ?>" class="<?php echo $page == $totalPages ? 'disabled' : ''; ?>">Next</a>
                </li>
                <li>
                    <a href="?id=<?php echo $categoryId; ?>&page=<?php echo $totalPages; ?>" class="<?php echo $page == $totalPages ? 'disabled' : ''; ?>">Last</a>
                </li>
            </ul>
        </nav>
    </div>
</body>

</html>