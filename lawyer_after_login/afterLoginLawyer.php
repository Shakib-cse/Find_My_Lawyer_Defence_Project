<?php

include('../loader.html');

$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "Database not connected";
}

$err = '';

session_start();

$current_email = $_SESSION['lawyer_login'];

if (!empty($_SESSION['lawyer_login'])) {
    $_SESSION['lawyer_login'];
} else {
    header('location:../login.php');
}

if (isset($_POST['logout-btn'])) {
    session_destroy();
    header('location:../login.php');
}


//finish conversation
if (isset($_POST['finish_conversation'])) {
    $user_email_consult = $_POST['user_email_consult'];
    $done = $_POST['done'];

    $submit_done = "UPDATE user_consulting SET lawyer_done = '$done', selected_slot = '' WHERE user_consult_email = '$user_email_consult' AND consulting_lawyer_email = '$current_email'";

    if ($conn->query($submit_done) === TRUE) {
        echo "<script>alert('Conversation Finish Successfully');</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// lawyer prove
$lawyer_sql = "SELECT * FROM lawyer_reg WHERE lawyer_email = '$current_email'";
$lawyer_result = $conn->query($lawyer_sql);
$lawyer_data = $lawyer_result->fetch_assoc();
$lawyer_image = $lawyer_data["lawyer_image"];
$meeting_link = $lawyer_data["meeting_link"];



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
    <link rel="stylesheet" href="../style/afterLoginLawyer.css">
</head>

<body>
    <header>
        <div class="header-area pt-2 pb-2">
            <div class="container">
                <div class="header-item">
                    <div class="logo-area">
                        <a href="./afterLoginLawyer.php" class="logo">
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
                                <li><a><form action="afterLoginLawyer.php" method="POST"><button class="header-list border-0" name="logout-btn"><b
                                    class="text-danger">Logout</b></button></form>
                                </a></li>
                                <li class="position-relative"><?php
                                if($meeting_link){
                                    echo '<a class="header-list" href="user_request.php"><b>Request</b><span class="request-number" id="request-number"><i class="fa-solid fa-bell"></i></span></a>';
                                }else{
                                    $err = 'Please fill up <a class="link-primary" href="create_link.php"> "Geranate conference information for consultation" </a> first';
                                }
                                ?></li>
                                <li><a class="header-list" target="_blank" href="http://bdlaws.minlaw.gov.bd/"><b>All law in Bangladesh</b></a></li>
                                <li><a class="header-list" href="#contact"><b>Contact</b></a></li>
                                <li><a class="header-list" href="#" onclick="viewSearchArea()"><i class="fa-solid fa-magnifying-glass"></i></a></li>
                                <li class="ms-3"><a class="pp_area" href="#">
                                        <?php
                                        if ($lawyer_image) {
                                            echo "<img class='profile-img' src='../lawyer_img/$lawyer_image' alt='profile image...'>";
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
    <main>
        <div class="profile-data-area">
            <div class="container">
                <div class="text-danger fs-2 text-center mb-2"><?php
                    echo $err;
                ?></div>
                <div class="data-item">
                    <div class="data-item-one">
                        <div>
                            <?php
                            if ($lawyer_image) {
                                echo "<img class='user-image' src='../lawyer_img/$lawyer_image' alt='profile image...'>";
                            } else {
                                echo "<img class='user-image' src='../none image/none-img.webp' alt='profile image...'>";
                            }
                            ?>
                            <h2 class="lawyer-name">
                                <?php echo $lawyer_data['lawyer_name']; ?>
                            </h2>
                            <p class="fw-bold text-primary">
                                <?php echo $lawyer_data['lawyer_title']; ?>
                            </p>
                            <div class="lawyer-location fw-bold">
                                <?php echo $lawyer_data['lawyer_prectice_location']; ?>
                            </div>
                            <a href="./lawyer_update_one.php" class="btn bg-warning text-black mt-3">Edit</a>
                        </div>
                        <div class="btn bg-success text-black mt-4"><a href="./create_link.php">Genarate Conference info for consulatation</a></div>
                    </div>
                    <div class="data-item-two">
                        <table>
                            <tr class="bg-info pb-5">
                                <th class="bg-secondary">Gmail:</th>
                                <th colspan="2" class="text-center">
                                    <?php echo $lawyer_data['lawyer_email']; ?>
                                </th>
                            </tr>
                            <tr>
                                <td class="text-decoration-underline bg-primary text-light">Study Information:</td>
                                <td>
                                    <?php echo $lawyer_data['lawyer_study_info']; ?>
                                </td>
                                <td class="bg-primary text-center"><a href="./lawyer_update_two.php"
                                        class="btn bg-warning text-black">Edit</a></td>
                            </tr>
                            <tr>
                                <td class="text-decoration-underline bg-info text-light">Prectice Location:</td>
                                <td>
                                    <?php echo $lawyer_data['lawyer_prectice_location']; ?>
                                </td>
                                <td rowspan="8" class="bg-primary"></td>
                            </tr>
                            <tr>
                                <td class="text-decoration-underline bg-primary text-light">Prectice Area:</td>
                                <td>
                                    <?php echo $lawyer_data['lawyer_Prectice_area']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-decoration-underline bg-info text-light">Exprience</td>
                                <td>
                                    <?php echo $lawyer_data['lawyer_exprience_time']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-decoration-underline bg-primary text-light">Bio:</td>
                                <td>
                                    <?php echo $lawyer_data['lawyer_bio']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-decoration-underline bg-info text-light">Consultation Time:</td>
                                <td>
                                    <?php echo $lawyer_data['lawyer_consultation_time']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-decoration-underline bg-primary text-light">Fee:</td>
                                <td>
                                    0<?php echo $lawyer_data['lawyer_fee']; ?> tk
                                </td>
                            </tr>
                            <tr>
                                <td class="text-decoration-underline bg-info text-light">Linkedin(if any):</td>
                                <td>
                                    <a class="text-primary" target="_blank" href="<?php echo $lawyer_data['lawyer_social']; ?>"><?php echo $lawyer_data['lawyer_social']; ?></a>
                                </td>
                            </tr>
                            <td class="text-decoration-underline bg-primary text-light">Gender:</td>
                            <td>
                                <?php echo $lawyer_data['lawyer_gender']; ?>
                            </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- profile data area end -->
    </main>
    <footer class="text-light">
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
        document.addEventListener('DOMContentLoaded', function () {
    // Show the preloader when a link is clicked
    document.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            document.getElementById('preloader').style.display = 'flex';
        });
    });

    // Hide the preloader when the new page is fully loaded
    window.addEventListener('load', function () {
        document.getElementById('preloader').style.display = 'none';
    });
});

    </script>
</body>

</html>