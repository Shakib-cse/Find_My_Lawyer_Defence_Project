<?php
$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "Database not connected";
}

$for_valid_input = $error1 = $error = $err_msg = '';

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

$lawyer_sql = "SELECT * FROM lawyer_reg WHERE lawyer_email = '$current_email'";
$lawyer_result = $conn->query($lawyer_sql);
$lawyer_data = $lawyer_result->fetch_assoc();
$lawyer_image = $lawyer_data["lawyer_image"];
$lawyer_meeting_link = $lawyer_data["meeting_link"];





//update time and link info
function validate24HourFormat($inputTime) {
    // Use regular expression to match HH:mm format
    $pattern = '/^([01][0-9]|2[0-3]):[0-5][0-9]$/';

    if (preg_match($pattern, $inputTime)) {
        return true;
    } else {
        $err_msg = "Invalid time. Please enter time in HH:mm format.\n";
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_consultation_time = $_POST["timeInput"];
    $end_consultation_time = $_POST["timeInput1"];

    $meeting_link = $_POST["meeting_link"];
    $offline_address = $_POST["offline_address"];
    $offline_address_name = $_POST["offline_address_name"];

    $onlineOrOffline = $_POST["onlineOrOffline"];
    $lawyer_submit_email = $current_email;


    $validTime1 = validate24HourFormat($start_consultation_time);
    $validTime2 = validate24HourFormat($end_consultation_time);

    //.....................................................................
    $startTime = $start_consultation_time;
    $endTime = $end_consultation_time;
    
    // Convert start and end times to DateTime objects for easier manipulation
    $startDateTime = new DateTime($startTime);
    $endDateTime = new DateTime($endTime);
    
    // Interval for 30 minutes
    $interval = new DateInterval('PT30M');
    
    // Create a DatePeriod object to iterate over 30-minute intervals
    $period = new DatePeriod($startDateTime, $interval, $endDateTime);
    
    // Iterate over each 30-minute interval and insert into the database
    foreach ($period as $dateTime) {
        $formattedTime = $dateTime->format('H:i');
        
    }

    //.....................................................................

    if ($validTime1 && $validTime2) {
        $error1 = $error = '';
            $lawyer_update_sql = "UPDATE lawyer_reg SET meeting_link='$meeting_link', end_consultation_time='$end_consultation_time', start_consultation_time='$start_consultation_time', offline_address='$offline_address', onlineOrOffline='$onlineOrOffline', offline_address_name='$offline_address_name' WHERE lawyer_email='$lawyer_submit_email'";
        

    if ($conn->query($lawyer_update_sql) === TRUE) {
        $record_updated = "<script>alert('Update is Successfull!');</script>";
        header("location:./afterLoginLawyer.php?$lawyer_id");
    } else {
        $record_updated = "<script>alert('Update is Error!');</script>";
    }
    } else {
        $for_valid_input = "Please enter valid times for both inputs.\n";
    }
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
    <link rel="stylesheet" href="../style/create_link.css">
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
                                <li><a>
                                        <form action="afterLoginLawyer.php" method="POST"><button
                                                class="header-list border-0" name="logout-btn"><b
                                                    class="text-danger">Logout</b></button></form>
                                    </a></li>
                                <li><a class="header-list" target="_blank" href="http://bdlaws.minlaw.gov.bd/"><b>All
                                            law in
                                            Bangladesh</b></a></li>
                                <li><a class="header-list" href="#contact"><b>Contact</b></a></li>
                                <li><a class="header-list" href="#" onclick="viewSearchArea()"><i
                                            class="fa-solid fa-magnifying-glass"></i></a></li>
                                <li class="ms-3"><a class="pp_area" href="./afterLoginLawyer.php">
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
        <div class="update-area">
            <div class="container overflow-hidden">
                <span class="error fw-bold text-danger fs-5 text-center"><?php echo $for_valid_input; ?></span>
                <span class="error fw-bold text-danger fs-5 text-center"><?php echo $err_msg; ?></span>
                <div class="update-item text-center">
                    <form action="create_link.php" method="POST">
                        <div class="item mb-3 mt-4">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="meeting_link">Meet Link</label>
                            <input class="w-100 p-2 border-0 rounded text-center" type="text" id="meeting_link"
                                name="meeting_link" value="<?php echo $lawyer_data['meeting_link']; ?>">
                        </div>
                        <div class="item mb-3">
                            <div>
                                <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="timeInput">Enter start consultation time in 24-hour format (HH:mm)*</label> <br>
                                <input class="w-100 p-2 border-0 rounded text-center"  type="text" id="timeInput" name="timeInput" placeholder="example (10:00)"  value="<?php echo $lawyer_data['start_consultation_time']; ?>" required>
                            </div>
                            <div>
                                <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="timeInput1">Enter end consultation time in 24-hour format (HH:mm)*</label> <br>
                                <input class="w-100 p-2 border-0 rounded text-center"  type="text" id="timeInput1" name="timeInput1" placeholder="example (15:00)" value="<?php echo $lawyer_data['end_consultation_time']; ?>" required>
                            </div>
                        </div>
                        <div class="item mb-3">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="online_offline">where are you want to colsultation*</label>
                            <div class="radio-area">
                            <div>
                                <label class="cursor-pointer" for="online">Online <input class="cursor-pointer" type="radio" name="onlineOrOffline" id="online" value="online" required></label>
                            </div>
                            <div>
                                <label class="cursor-pointer" for="offline">Offline <input class="cursor-pointer" type="radio" name="onlineOrOffline" id="offline" value="offline" required></label>
                            </div>
                            <div>
                                <label class="cursor-pointer" for="both">Both <input class="cursor-pointer" type="radio" name="onlineOrOffline" id="both" value="both" required></label>
                            </div>
                        </div>
                        </div>
                        <div class="item mb-3">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="offline_address">Offline Address google map*</label>
                            <textarea class="w-100 p-2 border-0 rounded text-center" type="text" id="offline_address"
                                name="offline_address" placeholder="Where client will meetingh with you(you can share google map link also)"><?php echo $lawyer_data['offline_address']; ?></textarea>
                        </div>
                        <div class="item mb-3">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="offline_address_name">Offline Address_name*</label>
                            <input class="w-100 p-2 border-0 rounded text-center" type="text" id="offline_address_name"
                                name="offline_address_name" placeholder="Where client will meetingh with you(you can share google map link also)" value="<?php echo $lawyer_data['offline_address_name']; ?>" required>
                        </div>
                        <button class="btn bg-success text-light mt-3" name="meeting_update">Update</button> <br>
                        <a target="_blank" class="btn bg-primary text-light mt-3" href="https://meet.google.com/">Get New Link</a> <br>
                        <h3 class="text-success mt-4">(If you face any problem then contact with us)</h3>
                    </form>
                </div>
            </div>
        </div> <!-- update area end -->
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
</body>

</html>