<?php
session_start();

# Database Connection File
include "db_conn.php";

# teacher helper function
include "php/func-teacher.php";
$teachers = get_all_teachers($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Information</title>

    <!-- bootstrap 5 CDN-->
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- bootstrap 5 Js bundle CDN-->
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="css/teacher_info.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/main.css">


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
                            <a class="nav-link mx-lg-2" href="library.php">Library</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 active" href="teacher-info.php">Information</a>
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
    <div class="all_teacher_card">
        <?php if ($teachers == 0) { ?>
            <div class="alert alert-warning 
            text-center p-5" role="alert">
                <img src="img/no_data.png" width="100">
                <br>
                There is no teacher info in the database
            </div>
        <?php } else { ?>
            <div class="card_display pdf-list">
                <?php foreach ($teachers as $teacher) { ?>
                    <div class="teacher_card">
                        <div class="img_decoration">
                            <img src="uploads/profile/<?= $teacher['profile'] ?>" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <p class="teacher_name">
                                <?= $teacher['name'] ?>
                            </p>
                            <p class="teacher_age">
                                <?= $teacher['age'] ?>
                            </p>
                            <p class="teacher_role">
                                <?= $teacher['role'] ?>
                            </p>
                            <p class="teacher_description">
                                <?= $teacher['description'] ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>


</body>

</html>