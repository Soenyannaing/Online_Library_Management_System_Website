<?php
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);
$bookpages = get_all_book_pages($conn);

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
    <title>Mechatronics Library</title>

    <!-- bootstrap 5 CDN-->
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- bootstrap 5 Js bundle CDN-->
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/library.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/main.css">

    <?php
    $records_per_page = 16;
    $total_records_query = $conn->query("SELECT COUNT(*) FROM books ORDER bY id DESC");
    $total_records = $total_records_query->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    if ($page > $total_pages) $page = $total_pages;

    $start = ($page - 1) * $records_per_page;

    $query = $conn->prepare("SELECT * FROM books ORDER bY id DESC LIMIT :start, :limit");
    $query->bindValue(':start', $start, PDO::PARAM_INT);
    $query->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
    $query->execute();
    $items = $query->fetchAll(PDO::FETCH_ASSOC);

    $first_page = 1;
    $last_page = $total_pages;

    // Define the number of page links to show
    $linksToShow = 3;

    // Calculate start and end page numbers for the range
    $startPage = max(1, $page - floor($linksToShow / 2));
    $endPage = min($total_pages, $page + floor($linksToShow / 2));

    // Adjust range if too close to the beginning or end
    if ($endPage - $startPage + 1 < $linksToShow) {
        $startPage = max(1, $endPage - $linksToShow + 1);
        $endPage = min($total_pages, $startPage + $linksToShow - 1);
    }

    // Calculate previous and next page numbers
    $prevPage = ($page > 1) ? $page - 1 : 1;
    $nextPage = ($page < $total_pages) ? $page + 1 : $total_pages;
    ?>

</head>

<body>

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
                            <a class="nav-link mx-lg-2 " href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 active" href="library.php">Library</a>
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

    <div class="tab">
        <div class="dropdown">
            <button class="dropbtn list-group-item list-group-item-action active" style="background-color: #581b98; color: white; padding-left: 16px;">Category</button>
            <div class="dropdown-content">
                <?php if ($categories == 0) {
                    // do nothing
                } else { ?>
                    <?php foreach ($categories as $category) { ?>

                        <a href="category.php?id=<?= $category['id'] ?>" class="list-group-item list-group-item-action" style="padding-top: 8px; padding-bottom: 8px;border-bottom: 1px solid #f0f0f0;">
                            <?= $category['name'] ?></a>
                <?php }
                } ?>
            </div>
        </div>

        <div class="dropdown">
            <button class="dropbtn list-group-item list-group-item-action active" style="background-color: #581b98; color: white; padding-left: 16px;">Class</button>
            <div class="dropdown-content">
                <?php if ($years == 0) {
                    // do nothing
                } else { ?>
                    <?php foreach ($years as $year) { ?>

                        <a href="year.php?id=<?= $year['id'] ?>" class="list-group-item list-group-item-action" style="padding-top: 8px; padding-bottom: 8px;border-bottom: 1px solid #f0f0f0;">
                            <?= $year['name'] ?></a>
                <?php }
                } ?>
            </div>
        </div>
    </div>

    <div class="d-flex pt-3 all_book_card ">
        <?php if ($items == 0) { ?>
            <div class="alert alert-warning 
                text-center p-5" role="alert">
                <img src="img/no_data.png" width="100">
                <br>
                There is no book in the database
            </div>
        <?php } else { ?>
            <div class="pdf-list d-flex flex-wrap">
                <?php foreach ($items as $book) { ?>
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

    <!-- Pagination Controls -->
    <div class="pagination">
        <nav class="pagni">
            <ul>
                <!-- First Page Button -->
                <li>
                    <a href="?page=<?php echo $first_page; ?>" class="<?php echo $page == 1 ? 'disabled' : ''; ?>">First</a>
                </li>

                <!-- Previous Page Button -->
                <li>
                    <a href="?page=<?php echo ($page - 1); ?>" class="<?php echo $page == 1 ? 'disabled' : ''; ?>">Previous</a>
                </li>

                <!-- Page Numbers with Ellipsis -->
                <?php if ($startPage > 1): ?>
                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li<?php echo ($i == $page) ? ' class="active"' : ''; ?>>
                            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($endPage < $total_pages): ?>
                        <li class="disabled"><span>...</span></li>
                        <li><a href="?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <?php for ($i = 1; $i <= $endPage; $i++): ?>
                        <li<?php echo ($i == $page) ? ' class="active"' : ''; ?>>
                            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($endPage < $total_pages): ?>
                        <li class="disabled"><span>...</span></li>
                        <li><a href="?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a></li>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Next Page Button -->
                <li>
                    <a href="?page=<?php echo ($page + 1); ?>" class="<?php echo $page == $total_pages ? 'disabled' : ''; ?>">Next</a>
                </li>

                <!-- Last Page Button -->
                <li>
                    <a href="?page=<?php echo $last_page; ?>" class="<?php echo $page == $total_pages ? 'disabled' : ''; ?>">Last</a>
                </li>
            </ul>
        </nav>
    </div>
</body>

</html>