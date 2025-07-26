<?php

include('loader.html');

$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "not connected";
}

$exist_email = $passValMsg = '';

session_start();
$current_user_email = $_SESSION['user_email_send'];

if (isset($_POST['user_submit'])) {
    $user_name = $_POST['user_name'];
    $user_phone = $_POST['user_phone'];
    $user_work = $_POST['user_work'];
    $user_location = $_POST['user_location'];
    $user_nid_number = $_POST['user_nid_number'];
    $user_age = $_POST['user_age'];

    $user_image = $_FILES['user_image']['name'];
    $pp_tmp_name = $_FILES['user_image']['tmp_name'];
    $pp_uploc = 'user_img/' . $user_image;

    $user_email = $current_user_email;

    $user_password = $_POST['user_password'];
    $user_md5_pass = md5($user_password);

    $user_gender = $_POST['user_gender'];
    $user_accept = $_POST['user_accept'];


    $email_select = "SELECT * FROM user_reg WHERE user_email = '$user_email'";
    $exc = mysqli_query($conn, $email_select);
    $count = mysqli_num_rows($exc);

    if ($count > 0) {
        $exist_email = 'This email already exists';
    } else {
        if (strlen($user_password) >= 6) {
            $sql = "INSERT INTO user_reg (user_name,user_phone,user_work,user_location,user_nid_number,user_age,user_image,user_email,user_md5_pass,user_gender,user_accept) VALUES('$user_name','$user_phone','$user_work','$user_location','$user_nid_number','$user_age','$user_image','$user_email','$user_md5_pass','$user_gender','$user_accept')";

            if ($conn->query($sql) == TRUE) {
                move_uploaded_file($pp_tmp_name, $pp_uploc);
                header('location:login.php?usercreated');
            }
        } else {
            $passValMsg = 'You must enter a password with at least six digits';
        }
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
    <link rel="stylesheet" href="./style/asAuser.css">
</head>

<body>
    <div class="form-area">
        <div class="logo-area">
            <a href="./index.php" class="logo">
                <img class="rounded-2" src="./image/logo_transparentN.jpg" alt="" width="90px" height="80px">
                <div class="logo-name">
                    <h3><b>FIND MY LAWYER</b></h3>
                    <span>A PLATFORM THAT CAN GIVE YOU A PERFECT LAWYER</span>
                </div>
            </a>
            <hr>
            <span>
                <?php
                if (isset($_POST['user_submit'])) {
                    echo "<P class='text-warning fs-3'> $exist_email </P>";
                }
                if (isset($_POST['user_submit'])) {
                    echo "<P class='text-warning fs-3'> $passValMsg </P>";
                }
                ?>
            </span>
        </div>
        <div class="container">
            <h2 class="form-head text-center"><u>SING UP FORM FOR USER</u></h2>
            <form action="asAuser.php" method="POST" enctype="multipart/form-data">
                <div class="all-form">
                    <div class="box-section">
                        <!-- <label class="box-label" for="name"><strong>User Name</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="text" name="user_name" id="name" placeholder="Full Name*"
                            required>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="phone"><strong>Phone</strong></label> -->
                        <input class="box-input" type="tel" name="user_phone" id="phone"
                            placeholder="Phone number (If any)" pattern="\d{11}">
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="work"><strong>Work</strong></label> -->
                        <input class="box-input" type="text" name="user_work" id="work"
                            placeholder="Your work (If any)">
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="user_location"><strong>Current Location</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="text" name="user_location" id="user_location"
                            placeholder="your location*" required>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="nid-number"><strong>Your NID/Birth certificate Number</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="number" name="user_nid_number" id="nid-number"
                            placeholder="NID/Birth certificate Number">
                    </div>
                    <div class="box-section text-center">
                        <!-- <label class="box-label" for="age"><strong>Age</strong></label> -->
                        <input class="box-input" type="text" name="user_age" placeholder="Yout age" id="age">
                    </div>
                    <div class="box-section">
                        <label class="box-label" for="image"><strong>Photo</strong></label>
                        <input class="form-file text-left w-100" type="file" name="user_image" id="image" accept="image/*">
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="password"><strong>Password</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="password" name="user_password" id="password"
                            placeholder="Password (Minimum 6 digit)" required>
                    </div>
                    <div class="box-section">
                        <label class="box-label" for="gender"><strong>Gender</strong> <span
                                class="mendatory">*</span></label>
                        <div class="radio-area">
                            <div>
                                <label class="cursor-pointer" for="male">Male</label>
                                <input class="cursor-pointer" type="radio" name="user_gender" id="male" value="male">
                            </div>
                            <div>
                                <label class="cursor-pointer" for="female">Female</label>
                                <input class="cursor-pointer" type="radio" name="user_gender" id="female"
                                    value="female">
                            </div>
                            <div>
                                <label class="cursor-pointer" for="trans">Trans</label>
                                <input class="cursor-pointer" type="radio" name="user_gender" id="trans"
                                    value="transgender">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="checkbox_area mb-3">
                    <label class="cursor-pointer" for="aar"><strong>Accept all rights</strong><span
                            class="mendatory">*</span></label>
                    <input class="cursor-pointer" type="checkbox" name="user_accept" id="aar" value="user accept all"
                        required>
                </div>
                <div class="btn-area">
                    <button class="all-btn" type="submit" name="user_submit">Sing Up</button>
                    <button class="all-btn" type="reset">Reset</button>
                </div>
            </form>
            <div class="go-to-reregiste text-center">have account?<a class="login-reg-btn" href="./login.php">Login</a></div>
        </div>
    </div>

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