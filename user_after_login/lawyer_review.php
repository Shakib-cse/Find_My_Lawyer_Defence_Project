<?php

include('../loader.html');

$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "Database not connected";
}

session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

$lawyer_show_data = $location_value = '';

//login prove
$current_email = $_SESSION['user_login'];

if (!empty($_SESSION['user_login'])) {
    $_SESSION['user_login'];
} else {
    header('location:../login.php');
}


// profile picture section
$user_sql = "SELECT * FROM user_reg WHERE user_email = '$current_email'";
$user_result = $conn->query($user_sql);
if ($user_result->num_rows > 0) {
    while ($user_data = $user_result->fetch_assoc()) {
        $user_image = $user_data["user_image"];
    }
}

// logout section
if (isset($_POST['logout-btn'])) {
    session_destroy();
    header('location:../login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIND MY LAWYER</title>

    <!-- google font cdn -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap link cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- css stylesheet link -->
    <link rel="stylesheet" href="../style/login_lawyer_list.css">
</head>

<body>
    <header>
        <div class="header-area pt-2 pb-2">
            <div class="container">
                <div class="header-item">
                    <div class="logo-area">
                        <a href="./afterLoginUser.php" class="logo">
                            <img class="rounded-2 me-3" src="../image/logo_transparentN.jpg" alt="logo..." width="90px"
                                height="80px">
                            <div class="logo-name">
                                <h3><b>FIND MY <span class="text-warning">LAWYER</span></b></h3>
                                <span>A PLATFORM THAT CAN GIVE YOU A PERFECT LAWYER</span>
                            </div>
                        </a>
                    </div>
                    <div class="header-menu">
                        <nav>
                            <ul class="header-menu-item">
                                <li><a>
                                        <form action="afterLoginUser.php" method="POST"><button
                                                class="header-list border-0" name="logout-btn"><b
                                                    class="text-danger">Logout</b></button></form>
                                    </a></li>
                                    <li class="position-relative"><a class="header-list" href="user_consulting_time.php"><b>Request</b><span class="request-number" id="request-number"><i class="fa-solid fa-bell"></i></span></a></li>
                                <li><a class="header-list" target="_blank" href="http://bdlaws.minlaw.gov.bd/"><b>All
                                            law in
                                            Bangladesh</b></a></li>
                                <li class="me-2"><a class="header-list" href="#contact"><b>Contact</b></a></li>
                                    <form id="search-form" method="GET" action="login_lawyer_list.php">
                                        <input class="text-black" type="text" name="searchQuery"
                                            placeholder="Search..." id="search_lawyer" required>
                                        <button class="text-black" type="submit">Search</button>
                                    </form>
                                </li>
                                <li class="ms-3"><a class="pp_area" href="./user_profile.php">
                                        <?php
                                        if ($user_image) {
                                            echo "<img class='profile-img' src='../user_img/$user_image' alt='profile image...'>";
                                        } else {
                                            echo "<img class='profile-img' src='../none image/none-img.webp' alt='profile image...'>";
                                        }
                                        ?>
                                    </a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header> <!-- header area end -->
    <main style="padding-top:150px;padding-bottom:100px;background:wheat;">
        <div class="container">
            <div class="review-item">
                <?php
                    //review show data
if (isset($_POST['show_review'])) {
    $lawyer_review_email = $_POST['lawyer_review_email'];

    $lawyer_review_sql = "SELECT * FROM lawyer_review WHERE lawyer_review_email = '$lawyer_review_email'";
    $lawyer_show_review = $conn->query($lawyer_review_sql);
    $review_sum = 0;
    $count_total_review = 0;
    $total_review_sum = 0;
    
    if ($lawyer_show_review->num_rows > 0) {
        $count_total_review = 0;
        $total_rating_sum = 0;
    
        while ($lawyer_review_data = $lawyer_show_review->fetch_assoc()) {
            $count_total_review++;
            $lawyer_rating = $lawyer_review_data['review_rating'];
            $lawyer_text = $lawyer_review_data['review_text'];

            if($lawyer_text){
                echo "<div class='bg-primary mb-4 rounded-2 p-2 fw-bold'>$lawyer_text</div>";
            }
    
            $total_rating_sum += $lawyer_rating;
        }

        $max_rating = $count_total_review*20;
    
        $total_rating = ($total_rating_sum / $max_rating)*10;
    }
    
} 
                ?>
            </div>
        </div>
    </main>
    <footer>
        <div class="upper-area" id="contact">
            <div class="container">
                <h1 class="mb-5 text-decoration-underline">Contact information</h1>
                <div class="upper-item">
                    <div class="upper-item-1">
                        <div class="upper-item-1-all">
                            <span class="fs-3">Email:</span>
                            <p>findmylawyer37@gmail.com</p>
                        </div>
                        <div class="upper-item-1-all">
                            <span class="fs-3">Phone:</span>
                            <a href="tel:">01775584107</a>
                        </div>
                    </div>
                    <div class="upper-item-2">
                        <div class="contact-item-2">
                            <h4 class="mb-5 fs-2">More Ways to Contact</h4>
                            <ul class="social-btn">
                                <li class="social-sec"><a href="https://www.youtube.com/" target="_blank"><i
                                            class="fa-brands fa-youtube"></i></a></li>
                                <li class="social-sec"><a href="https://www.facebook.com/" target="_blank"><i
                                            class="fa-brands fa-facebook"></i></a></li>
                                <li class="social-sec"><a href="https://www.youtube.com/" target="_blank"><i
                                            class="fa-brands fa-linkedin"></i></a></li>
                                <li class="social-sec"><a href="https://www.youtube.com/" target="_blank"><i
                                            class="fa-brands fa-skype"></i></a></li>
                                <li class="social-sec"><a href="https://www.youtube.com/" target="_blank"><i
                                            class="fa-brands fa-square-twitter"></i></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- contact area end -->
        <div class="lower-footer bg-black p-2 text-center">
            <div class="container">
                <span>&copy; All rights reserved by owner.</span>
            </div>
        </div>
    </footer> <!-- footer area end -->

    <script>
        window.addEventListener('load', function () {
            document.getElementById('preloader').style.display = 'none';
        });
    </script>

</body>

</html>