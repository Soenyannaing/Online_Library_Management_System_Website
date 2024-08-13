<?php
session_start();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechatronics Library</title>

    <!-- bootstrap 5 CDN-->
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <!-- bootstrap 5 Js bundle CDN-->
    <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/about.css">

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
                            <a class="nav-link mx-lg-2" href="teacher-info.php">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 active" href="about.php">About</a>
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
        <div class="detel">
            <div class="col-lg-6">
                <div class="text">
                    <h1>Hello <span>I,m Soe Nyan Naing</span></h1>
                    <p>I'm a final year student at Mandalay Technological University,pursing a degree in Mechatronics Major.For my final-year thesis, I chose to develop an Online Library Management System. My passion and a desire to address the challenges faced by traditional library management systems motivated me to create a solution that enhances user experience and streamlines library operations.
                        <br>Feel free to contact me for any inquiries or to discuss potential collaborations. Thank you for visiting my thesis!
                    </p>
                </div>
                <div class="social-icons">
                    <a href="https://www.facebook.com/soe.n.naing.104?mibextid=ZbWKwL">
                        <img src="../mechatronics-library/icon/facebookdark.png" alt="">
                    </a>
                    <a href=mailto:"soenyannaing204999@gmail.com">
                        <img src="../mechatronics-library/icon/maildark.png" alt="">
                    </a>
                </div>
            </div>
            <div class="images">
                <img src="../mechatronics-library/img/finalshape.png" class="shape">
                <img src="../mechatronics-library/img/finalsnn.png" class="boy">
            </div>
        </div>


</body>

</html>