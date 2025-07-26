<?php


$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "Database not connected";
}

$chang_time_slot = $booked = $past_time_message = $time_1 = $time_3 = $time_3 =  $selected_slots_2 = $er_0 = '';

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

//get data for lawyer information

if (isset($_GET['data'])) {
    $dataFromUrl = $_GET['data'];
    $_SESSION['userData'] = $dataFromUrl;

    $lawyer_sql = "SELECT * FROM lawyer_reg WHERE lawyer_email = '$dataFromUrl'";
    $lawyer_result = $conn->query($lawyer_sql);
    if ($lawyer_result->num_rows > 0) {
        $lawyer_data = $lawyer_result->fetch_assoc();
            $start_consultation_time = $lawyer_data["start_consultation_time"];
            $end_consultation_time = $lawyer_data["end_consultation_time"];
        }
} else {
    if (isset($_SESSION['userData'])) {
        $dataFromUrl = $_SESSION['userData'];

        $lawyer_sql = "SELECT * FROM lawyer_reg WHERE lawyer_email = '$dataFromUrl'";
        $lawyer_result = $conn->query($lawyer_sql);
        if ($lawyer_result->num_rows > 0) {
            $lawyer_data = $lawyer_result->fetch_assoc();
                $start_consultation_time = $lawyer_data["start_consultation_time"];
                $end_consultation_time = $lawyer_data["end_consultation_time"];
            }
    } else {
        header("Location: lawyer_profile.php");
        exit();
    }
}



//information for consultation request...........................
date_default_timezone_set('Asia/Dhaka');

if (isset($_POST['user_consulte'])) {
    $selected_slots = $_POST["selected_slots"];
    if (isset($selected_slots[0])) {
        $selected_slots_1 = $selected_slots[0];
    }
    

    $selected_slots_count = count($selected_slots);

    $selected_slots_str = implode($selected_slots);

    $lawyer_review_email = $_POST['hidden_lawyer_email'];
    $user_issue_consulte = $_POST['user_issue_consulte'];
    $user_consult_email = $current_email;
    $hidden_lawyer_email = $_POST['hidden_lawyer_email'];
    $online_offline = $_POST['online_offline'];
    $user_name_consulte = $_POST['user_name_consulte'];

    $start_date_user = $_POST['start_date_user'];

    $user_file_consulte = $_FILES['user_file_consulte']['name'];
    $pp_tmp_name = $_FILES['user_file_consulte']['tmp_name'];
    $pp_uploc = '../user_consulting_file/' . $user_file_consulte;

    move_uploaded_file($pp_tmp_name, $pp_uploc);

    $booking_status = 'booked';



    // Correctly format the time string with a space between the time and minutes
    $selected_datetime = new DateTime("$start_date_user $selected_slots_1", new DateTimeZone('Asia/Dhaka'));
    $current_datetime = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

    if ($selected_datetime->format('U') < $current_datetime->format('U')) {
        $past_time_message = "Selected time is in the past. Please choose a present or future time.";
    } elseif($selected_slots_count > 1){
        $er_0 = 'Maximum time slot is 1. You can get Appointments again. Thank you';
    }
    else {
        $conn->begin_transaction();

        

        try {
            $checkAvailabilityQuery = "SELECT * FROM user_consulting 
                           WHERE selected_slot LIKE '%$selected_slots_str%'
                           AND start_date_user LIKE '%$start_date_user%'
                           AND consulting_lawyer_email = '$dataFromUrl'";

            $result = $conn->query($checkAvailabilityQuery);

            if ($result->num_rows == 0) {
                $user_consulting_sql = "INSERT INTO user_consulting (user_consult_email, consulting_lawyer_email, user_issue, user_file, user_consult_name, online_offline, selected_slot, selected_slots_count, booking_status,start_date_user, user_submite_time) VALUES ('$user_consult_email', '$dataFromUrl', '$user_issue_consulte', '$user_file_consulte', '$user_name_consulte', '$online_offline', '$selected_slots_str', '$selected_slots_count', '$booking_status','$start_date_user', NOW())";

                if ($conn->query($user_consulting_sql) == TRUE) {
                    $conn->commit();
                    move_uploaded_file($pp_tmp_name, $pp_uploc);
                    header('location:user_consulting_time.php');
                } else {
                    $conn->rollback();
                    echo "Error inserting into the database: " . $conn->error;
                }
            } else {
                $conn->rollback();
                $chang_time_slot = "This slot is booked. Choose another time slot";
            }
        } catch (Exception $e) {
            $conn->rollback();
            echo "Exception: " . $e->getMessage();
        }
    }
}



//Function to get available consultation slots

function getAvailableTimeSlots($start_time, $end_time, $slot_duration) {
    $available_slots = array();
    $current_time = strtotime($start_time);

    while ($current_time < strtotime($end_time)) {
        $slot_start = date("H:i", $current_time);
        $current_time = strtotime("+$slot_duration minutes", $current_time);
        $slot_end = date("H:i", $current_time);

        $available_slots[] = array("start" => $slot_start, "end" => $slot_end);
    }

    return $available_slots;
}


$start_time = "$start_consultation_time";
$end_time = "$end_consultation_time";
$slot_duration = 30;

$available_slots = getAvailableTimeSlots($start_time, $end_time, $slot_duration);



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
    <link rel="stylesheet" href="../style/user_consultation_info.css">
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
                                    <li class="position-relative"><a class="header-list" href="user_consulting_time.php"><b>Request</b><span class="request-number" id="request-number"><i class="fa-solid fa-bell"></i></span></a></li>
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
        <div class="problem-info-area">
            <div class="container">
                <div class="text-center fs-2 text-danger fw-bold"><?php
                    echo $chang_time_slot;
                ?></div>
                <div class="text-center fs-2 text-danger fw-bold"><?php
                    echo $past_time_message;
                ?></div>
                <div class="text-center fs-2 text-danger fw-bold"><?php
                    echo $er_0;
                ?></div>
                <div class="text-center fs-2 fw-bold text-decoration-underline mb-4">Booking for consultation</div>
                <div class="problem-info-item text-center">
                <form action="user_consultation_info.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <div class="item mb-3">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="user_name_consulte">Your Name*</label>
                            <input class="w-100 p-2 border-0 rounded text-center" type="text" id="user_name_consulte" name="user_name_consulte" required>
                            <?php 
                            if($lawyer_data["onlineOrOffline"] == 'both'){
                               echo '<div class="item mb-3">
                               <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="online_offline">Where you want to consultation*</label>
                               <div class="radio-area">
                               <div>
                                   <label class="cursor-pointer" for="online">Online <input class="cursor-pointer" type="radio" name="online_offline" id="online" value="online" required></label>
                               </div>
                               <div>
                                   <label class="cursor-pointer" for="offline">Offline <input class="cursor-pointer" type="radio" name="online_offline" id="offline" value="offline" required></label>
                               </div>
                           </div>
                           </div>';
                            } elseif($lawyer_data["onlineOrOffline"] == 'online'){
                                echo '<div class="item mb-3">
                                <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="online_offline">Where you want to consultation*</label>
                                <div class="radio-area">
                                <div>
                                    <label class="text-success fw-bold fs-5" for="online">Online <input class="cursor-pointer" type="radio" name="online_offline" id="online" value="online" selected checked hidden required></label>
                                </div>
                            </div>
                            </div>';
                             } if($lawyer_data["onlineOrOffline"] == 'offline'){
                                echo '<div class="item mb-3">
                                <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="online_offline">Where you want to consultation*</label>
                                <div class="radio-area">
                                <div>
                                    <label class="text-success fw-bold fs-5" for="offline">Offline <input class="text-success fw-bold" type="radio" name="online_offline" id="offline" value="offline" selected checked hidden  required></label>
                                </div>
                            </div>
                            </div>';
                             }
                        ?>
                        </div>
                        <div class="item mb-3">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="user_issue_consulte">Decribe your issue</label>
                            <textarea class="w-100 p-2 border-0 rounded text-center" id="user_issue_consulte" name="user_issue_consulte"></textarea>
                        </div>
                        <div class="item mb-3">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="user_issue_consulte">Insert date for booking*</label>
                            <input type="date" id="start_date" name="start_date_user" id="selectedDate" required min="<?php echo date('Y-m-d'); ?>">

                        </div>
                        <div class="item mb-3">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="selected_slots">Select time slots for consultation*</label>
                            <select class="w-100" name="selected_slots[]" id="selected_slots" multiple required>
                            <?php 
                            foreach ($available_slots as $slot) {
                                echo "<option class='text-center fs-4' value='" . $slot['start'] . "'>" . $slot['start'] . " - " . $slot['end'] . "</option>";
                            }
                            ?>
                        </select>
                        </div>
                        <div class="item mb-3">
                            <label class="fs-5 text-decoration-underline fw-bold" for="user_file_consulte">file(if any)</label> <br>
                            <input class="ms-1" type="file" id="user_file_consulte" name="user_file_consulte">
                        </div>
                        <input type="hidden" id="hidden_lawyer_email" name="hidden_lawyer_email">
                        <button type="submit" class="btn bg-success text-light mt-3" name="user_consulte">Submit</button>
                    </form>
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

    <script src="../script/user_consultation_info.js"></script>
</body>

</html>