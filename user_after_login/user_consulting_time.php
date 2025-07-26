<?php
$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "Database not connected";
}

$not_valid = $numericValue = '';

session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

//logout btn
if (isset($_POST['logout-btn'])) {
    session_destroy();
    header('location:../login.php');
}

//user profile picture info
$current_email = $_SESSION['user_login'];

if (!empty($_SESSION['user_login'])) {
    $_SESSION['user_login'];
} else {
    header('location:../login.php');
}

$user_sql = "SELECT * FROM user_reg WHERE user_email = '$current_email'";
$user_result = $conn->query($user_sql);
if ($user_result->num_rows > 0) {
    while ($user_data = $user_result->fetch_assoc()) {
        $user_image = $user_data["user_image"];
    }
}


//showing time for consulting
$consulting_sql = "SELECT * FROM user_consulting WHERE user_consult_email = '$current_email'";
$consulting_result = $conn->query($consulting_sql);
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
    <link rel="stylesheet" href="../style/user_consulting_time.css">
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
                                <li><a class="header-list" href="afterLoginUser.php"><b>Home</b></a></li>
                                <li><a>
                                        <form action="afterLoginUser.php" method="POST"><button
                                                class="header-list border-0" name="logout-btn"><b
                                                    class="text-danger">Logout</b></button></form>
                                    </a></li>
                                <li><a class="header-list" target="_blank" href="http://bdlaws.minlaw.gov.bd/"><b>All
                                            law in
                                            Bangladesh</b></a></li>
                                <li><a class="header-list" href="#contact"><b>Contact</b></a></li>
                                <li><a class="header-list" href="#" onclick="viewSearchArea()"><i
                                            class="fa-solid fa-magnifying-glass"></i></a></li>
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
        <div class="consult-info-area">
            <div class="container">
            <h3 class="text-danger"><?php echo $not_valid;?></h3>
                <div class="consult-info-item">
                    <div class="consulting-time-info">
                        <?php
                            if ($consulting_result->num_rows > 0) {
                                while ($consulting_data = $consulting_result->fetch_assoc()) {
                                    //consulting information
                                    $consulting_lawyer_email = $consulting_data["consulting_lawyer_email"];
                                    $consulting_user_email = $consulting_data["user_consult_email"];
                                    $consulting_lawyer_done = $consulting_data["lawyer_done"];
                                    $consulting_user_done = $consulting_data["user_done"];
                                    $consulting_online_offline = $consulting_data["online_offline"];
                                    $time_slots_array = str_split($consulting_data['selected_slot'], 5);
                                    $formatted_time_slots = implode(', ', $time_slots_array);
                                    
                                    //lawyer infotmation
                                    $consulting_lawyer_sql = "SELECT * FROM lawyer_reg WHERE lawyer_email = '$consulting_lawyer_email'";
                                    $consulting_lawyer_info = $conn->query($consulting_lawyer_sql);
                                    $consulting_lawyer_data = $consulting_lawyer_info->fetch_assoc();
                                    $consult_lawyer_name = $consulting_lawyer_data["lawyer_name"];

                                    if ($consulting_lawyer_email && !$consulting_lawyer_done && $consulting_online_offline == 'online') {
                                        

                                        echo "<div class='bg-info p-2 rounded-2 mt-2'><h3 class='lawyer-name'>You are consulting by " . $consulting_lawyer_data['lawyer_name'] . "</h3>
                                        <h4 class='lawyer-title text-primary'>Consultation Time: " . $formatted_time_slots . " (24 hour format). <br>Date: "  . $consulting_data['start_date_user'] .  "</h4>
                                        <h4 class='lawyer-title'>Duration: 30 minutes (For every slot)</h4>
                                        <p class='lawyer-location'>Google meet link: <a class='text-danger' target='_blank' href=". $consulting_lawyer_data['meeting_link'] . ">"  . $consulting_lawyer_data['meeting_link'] . "</a></p>
                                        <h4 class='lawyer-title text-danger'>Appointment request time: " . $consulting_data['user_submite_time'] . "</h4>
                                        </div>";
                                    } elseif ($consulting_lawyer_email && !$consulting_lawyer_done && $consulting_online_offline == 'offline'){
                                        echo "<div class='bg-info p-2 rounded-2 mt-2'><h3 class='lawyer-name'>You are consulting by " . $consulting_lawyer_data['lawyer_name'] . "</h3>
                                        <h4 class='lawyer-title text-primary'>Time: " . $formatted_time_slots . " (24 hour format). <br>Date: "  . $consulting_data['start_date_user'] .  "</h4>
                                        <h4 class='lawyer-title'>Duration: 30 minutes (For every slot)</h4>
                                        <h4 class='lawyer-title'>Offline Address: " . $consulting_lawyer_data['offline_address_name'] . "</h4>  
                                        <h4 class='lawyer-title'>Google map: " . $consulting_lawyer_data['offline_address'] . "</h4>
                                        <h4 class='lawyer-title text-danger'>Appoinment request time: " . $consulting_data['user_submite_time'] . "</h4>
                                        </div>";
                                    }
                                    
                                    if ($consulting_lawyer_email && $consulting_lawyer_done && !$consulting_user_done && $consulting_user_email=$current_email && $consulting_lawyer_done) {
                                        echo '<form class="bg-secondary p-2 rounded-2 text-white mt-4" action="afterLoginUser.php" method="POST">
                                        <h4><u>Leave a review for ' . $consult_lawyer_name . '</u></h4>
                                        <div id="review-from">
                                        <input type="hidden" name="lawyer_review_email" value=' . $consulting_lawyer_email .'>
                                        <input class="bg-black text-white p-2 border-0 rounded-2 w-25" type="number" name="review_rating" placeholder="rating*( out of 20.)" min="0" max="20" required>
                                        <textarea class="bg-black text-white p-2 border-0 rounded-2 w-25" type="text" name="review_text" placeholder="exprience about this lawyer(if any)"></textarea>
                                        <button class="btn bg-success" name="submit_review">Submit Review</button>
                                        </div>
                                        </form>';
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div> <!-- problem info area end -->
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

</body>

</html>