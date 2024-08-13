<?php
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# year helper function
include "php/func-year.php";
$years = get_all_year($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

# activity helper function
include "php/func-activity.php";
$activities = get_all_activities($conn);

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

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
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
                            <a class="nav-link mx-lg-2 active" href="index.php">Home</a>
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

    <!-- Hero -->
    <section id="hero" class="min-vh-100 d-flex align-items-center text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-left" class="text-uppercase text-white fw-semibold display-2">Welcome to Mechatronics</h1>
                    <h5 class="text-white mt-3 mb-4" data-aos="fade-right">More knowledge, come and join with us.</h5>
                    <div data-aos="fade-up" data-aos-delay="50">
                        <a href="library.php" class="library-btn me-2">Go to Library</a>
                        <a href="teacher-info.php" class="info-btn ms-2">Information</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="50">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">About</h1>
                        <div class="line"></div>
                        <p>Mechatronics is a multidisciplinary field that refers to the skill sets needed in the contemporary, advanced automated manufacturing industry</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6" data-aos="fade-down" data-aos-delay="50">
                    <img src="../mechatronics-library/img/robot.jpg" alt="">
                </div>
                <div class="col-lg-5" data-aos="fade-down" data-aos-delay="150">
                    <h1 class="mt-4">Mechatronics</h1>
                    <p class="mt-3 mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corrupti aperiam magnam eos non facere assumenda officia quia, fugiat porro libero consequuntur quam reprehenderit perspiciatis illo eveniet consequatur nesciunt numquam ut!</p>
                    <div class="d-flex pt-4">
                        <div class="iconbox me-4 mb-4">
                            <img src="../mechatronics-library/icon/mail.png" alt="">
                        </div>
                        <div>
                            <h5>We are innovative</h5>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                    <div class="d-flex pt-4 ">
                        <div class="iconbox me-4 mb-4">
                            <img src="../mechatronics-library/icon/bxs-user.svg" alt="">
                        </div>
                        <div>
                            <h5>We are analytical thinkers</h5>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                    <div class="d-flex pt-4">
                        <div class="iconbox me-4 mb-4">
                            <img src="../mechatronics-library/icon/prize.png" alt="">
                        </div>
                        <div>
                            <h5>We are creative</h5>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="section-padding border-top">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Mission</h1>
                        <div class="line"></div>
                        <p>Our Mission is to be able to take the lead in industrial production and train mechatronics engineering subjects to learn good habits and to produce good engineers and to be a place to disseminate modern mechatronics engineering knowledge.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Vision</h1>
                        <div class="line"></div>
                        <p>Mechatronics Engineering Department of Mandalay Technological University aims to produce internationally qualified mechatronics engineers and automation and control mechatronics engineering researchers needed for industrial manufacturing in the establishment of a modern industrial country, and aims to be a teaching and research department that can support the necessary technologies in Myanmar's industrial manufacturing industries.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center">
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <img src="../mechatronics-library/icon/stack.png" alt="">
                        </div>
                        <h5 class="mt-4 mb-3">Robotics</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae repellendus amet</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <img src="../mechatronics-library/icon/stack.png" alt="">
                        </div>
                        <h5 class="mt-4 mb-3">Control</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae repellendus amet</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <img src="../mechatronics-library/icon/stack.png" alt="">
                        </div>
                        <h5 class="mt-4 mb-3">Data Analyst</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae repellendus amet</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="450">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <img src="../mechatronics-library/icon/stack.png" alt="">
                        </div>
                        <h5 class="mt-4 mb-3">Automobile</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae repellendus amet</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="550">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <img src="../mechatronics-library/icon/stack.png" alt="">
                        </div>
                        <h5 class="mt-4 mb-3">Project Engineer</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae repellendus amet</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="650">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <img src="../mechatronics-library/icon/stack.png" alt="">
                        </div>
                        <h5 class="mt-4 mb-3">Software Engineer</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae repellendus amet</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="counter" class="section-padding">
        <div class="container text-center">
            <div class="row g-4 ">
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <h1 class="text-white display-4">100+</h1>
                    <h6 class="text-uppercase mt-3 mb-0 text-white">Total Teachers</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <h1 class="text-white display-4">500+</h1>
                    <h6 class="text-uppercase mt-3 mb-0 text-white">Current Students</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <h1 class="text-white display-4">100+</h1>
                    <h6 class="text-uppercase mt-3 mb-0 text-white">Total Projects</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="450">
                    <h1 class="text-white display-4">150+</h1>
                    <h6 class="text-uppercase mt-3 mb-0 text-white">Educated Students</h6>
                </div>
            </div>
        </div>
    </section>

    <section id="team" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Essential Persons</h1>
                        <div class="line"></div>
                        <p>Mechatronics is a multidisciplinary field that refers to the skill sets needed in the contemporary, advanced automated manufacturing industry</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="150">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img style="height: 450px;" src="../mechatronics-library/img/member1.jpg" alt="">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Win Win</h4>
                            <p class="mb-0 text-white">Department Head</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="250">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img style="height: 450px;" src="../mechatronics-library/img/member2.jpg" alt="">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Aung Aung</h4>
                            <p class="mb-0 text-white">Professor</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="350">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img style="height: 450px;" src="../mechatronics-library/img/member3.jpg" alt="">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Aye Aye</h4>
                            <p class="mb-0 text-white">Lecturer</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3" data-aos="fade-down">
                    <a href="teacher-info.php" class="library-btn ms-2">See all</a>
                </div>
            </div>
        </div>
    </section>

    <section id="blog" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Recent News & Articles</h1>
                        <div class="line"></div>
                        <p>Mechatronics is a multidisciplinary field that refers to the skill sets needed in the contemporary, advanced automated manufacturing industry</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if ($activities == 0) { ?>
                    <div class="alert alert-warning 
                        text-center p-5" role="alert">
                        <img src="img/no_data.png" width="100">
                        <br>
                        There is no activity in the database
                    </div>
                <?php } 
                
                else { ?>
                    <?php foreach ($activities as $activity) { ?>
                        <div class="col-md-4" data-aos="fade-down" data-aos-delay="150">
                            <div class="team-member image-zoom">
                                <div class="image-zoom-wrapper">
                                    <img src="uploads/photo/<?= $activity['photo'] ?>" alt="">
                                </div>
                                <h5 class="mt-3"><?= $activity['title'] ?></h5>
                                <p style="font-size: 14px; color:#636363;"><?= $activity['description'] ?></p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </section>

    <section id="portfolio" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Memories</h1>
                        <div class="line"></div>
                        <p>Mechatronics is a multidisciplinary field that refers to the skill sets needed in the contemporary, advanced automated manufacturing industry</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="150">
                    <div class="portfolio-item image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="../mechatronics-library/img/robot01.jpg" alt="">
                        </div>
                        <a href="../mechatronics-library/img/robot01.jpg" data-fancybox="gallery" class="iconbox"><img src="../mechatronics-library/img/search.png" alt=""></a>
                    </div>
                    <div class="portfolio-item image-zoom mt-4">
                        <div class="image-zoom-wrapper">
                            <img src="../mechatronics-library/img/major1.jpg" alt="">
                        </div>
                        <a href="../mechatronics-library/img/major1.jpg" data-fancybox="gallery" class="iconbox"><img src="../mechatronics-library/img/search.png" alt=""></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="250">
                    <div class="portfolio-item image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="../mechatronics-library/img/major2.jpg" alt="">
                        </div>
                        <a href="../mechatronics-library/img/major2.jpg" data-fancybox="gallery" class="iconbox"><img src="../mechatronics-library/img/search.png" alt=""></a>
                    </div>
                    <div class="portfolio-item image-zoom mt-4">
                        <div class="image-zoom-wrapper">
                            <img src="../mechatronics-library/img/robot04.jpg" alt="">
                        </div>
                        <a href="../mechatronics-library/img/robot04.jpg" data-fancybox="gallery" class="iconbox"><img src="../mechatronics-library/img/search.png" alt=""></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="350">
                    <div class="portfolio-item image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="../mechatronics-library/img/robot05.jpg" alt="">
                        </div>
                        <a href="../mechatronics-library/img/robot05.jpg" data-fancybox="gallery" class="iconbox"><img src="../mechatronics-library/img/search.png" alt=""></a>
                    </div>
                    <div class="portfolio-item image-zoom mt-4">
                        <div class="image-zoom-wrapper">
                            <img src="../mechatronics-library/img/major3.jpg" alt="">
                        </div>
                        <a href="../mechatronics-library/img/major3.jpg" data-fancybox="gallery" class="iconbox"><img src="../mechatronics-library/img/search.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark footer">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mechatronics">Mechatronics</h5>
                        <div class="line">
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <div class="social-icons">
                            <a href="">
                                <img style="width: 20px;" src="../mechatronics-library/icon/facebook.svg" alt="">
                            </a>
                            <a href="">
                                <img style="width: 20px;" src="../mechatronics-library/icon/gmail.svg" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">FIELDS</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="">Ai/Vision</a></li>
                            <li><a href="">Robotics</a></li>
                            <li><a href="">Control</a></li>
                            <li><a href="">Sensor</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">Experiments</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="">In-house Training</a></li>
                            <li><a href="">Excursion</a></li>
                            <li><a href="">Internship</a></li>
                            <li><a href="">Laboratory</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">CONTACT US</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="">MC Department (M.T.U)</a></li>
                            <li><a href="">+959788382761</a></li>
                            <li><a href="">www.mechatronics.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row g-4 justify-content-between">
                    <div class="col-auto">
                        <p class="mb-0">© Copyright Mechatronics. All Rights Reserved</p>
                    </div>
                    <div class="col-auto">
                        <p class="mb-0">Designed by <a href="">Soe Nyan Naing</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="../mechatronics-library/js/main.js"></script>

</body>

</html>