<?php

include('loader.html');

$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "not connected";
}

$passValMsg = $exist_email = $phoneValMsg = '';

session_start();
$current_lawyer_email = $_SESSION['email_send'];

if (isset($_POST['lawyer_submit'])) {
    $lawyer_name = $_POST['lawyer_name'];
    $lawyer_study_info = $_POST['lawyer_study_info'];
    $lawyer_title = $_POST['lawyer_title'];
    $lawyer_Prectice_area = $_POST['lawyer_Prectice_area'];
    $lawyer_prectice_location = $_POST['lawyer_prectice_location'];
    $lawyer_exprience_time = $_POST['lawyer_exprience_time'];

    $lawyer_certificate = $_FILES['lawyer_certificate']['name'];
    $c_tmp_name = $_FILES['lawyer_certificate']['tmp_name'];
    $c_uploc = 'lawyer_certificate/' .$lawyer_certificate;

    $lawyer_image = $_FILES['lawyer_image']['name'];
    $pp_tmp_name = $_FILES['lawyer_image']['tmp_name'];
    $pp_uploc = 'lawyer_img/' .$lawyer_image;

    $lawyer_bio = $_POST['lawyer_bio'];
    $lawyer_consultation_time = $_POST['lawyer_consultation_time'];
    $lawyer_fee = $_POST['lawyer_fee'];

    $lawyer_email = $current_lawyer_email;

    $lawyer_password = $_POST['lawyer_password'];
    $lawyer_md5_pass = md5($lawyer_password);

    $lawyer_social = $_POST['lawyer_social'];
    $lawyer_gender = $_POST['lawyer_gender'];
    $lawyer_accept = $_POST['lawyer_accept'];


    $email_select = "SELECT * FROM lawyer_reg WHERE lawyer_email = '$lawyer_email'";
    $exc = mysqli_query($conn,$email_select);
    $count = mysqli_num_rows($exc);

    if($count>0){
        $exist_email = 'This email already exists';
    }else{
        if(strlen($lawyer_password) >= 6){
            $sql = "INSERT INTO lawyer_reg (lawyer_name,lawyer_study_info,lawyer_title,lawyer_Prectice_area,lawyer_prectice_location,lawyer_exprience_time,lawyer_certificate,lawyer_image,lawyer_bio,lawyer_consultation_time,lawyer_fee,lawyer_email,lawyer_md5_pass,lawyer_social,lawyer_gender,lawyer_accept) VALUES('$lawyer_name','$lawyer_study_info','$lawyer_title','$lawyer_Prectice_area','$lawyer_prectice_location','$lawyer_exprience_time','$lawyer_certificate','$lawyer_image','$lawyer_bio','$lawyer_consultation_time','$lawyer_fee','$lawyer_email','$lawyer_md5_pass','$lawyer_social','$lawyer_gender','$lawyer_accept')";
    
            if ($conn->query($sql) == TRUE) {
                move_uploaded_file($c_tmp_name,$c_uploc);
                move_uploaded_file($pp_tmp_name,$pp_uploc);
                header('location:login.php?lawyercreated');
            }
        }else{
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
    <link rel="stylesheet" href="./style/asAlawyer.css">
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
            <span><?php
                if (isset($_POST['lawyer_submit'])) {
                    echo "<P class='text-warning fs-3'> $passValMsg </P>";
                }
                if (isset($_POST['lawyer_submit'])) {
                    echo "<P class='text-warning fs-3'> $exist_email </P>";
                }
                if (isset($_POST['lawyer_submit'])) {
                    echo "<P class='text-warning fs-3'> $phoneValMsg </P>";
                }
            ?></span>
        </div>
        <div class="container">
            <h2 class="form-head"><u>SING UP FORM FOR A LAWYER</u></h2>
            <form action="asAlawyer.php" method="POST" enctype="multipart/form-data">
                <div class="all-form">
                    <div class="box-section">
                        <!-- <label class="box-label" for="name"><strong>Lawyer Name</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="text" name="lawyer_name" id="name" placeholder="Full Name*" required>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="social"><strong>Social/website link</strong></label> -->
                        <input class="box-input" type="text" name="lawyer_social" id="social" placeholder="Linkedin Profile(If any)">
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="title"><strong>Title</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="text" name="lawyer_title" id="title" placeholder="Title (Attorney/ advocate/barrister)*" required>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="areaOfPrectice"><strong>Area of prectice</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="text" name="lawyer_Prectice_area" id="areaOfPrectice" placeholder="Speciality (Tax law, Divorce etc.)*" required>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="location"><strong>Location</strong> <span class="mendatory">*</span></label> -->
                        <select class="box-input" name="lawyer_prectice_location" id="location" required>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Mymensingh">Mymensingh</option>
                            <option value="Khulna">Khulna</option>
                            <option value="Barisal">Barisal</option>
                            <option value="Chittagong">Chittagong</option>
                            <option value="Rangpur">Rangpur</option>
                            <option value="Rajshahi">Rajshahi</option>
                            <option value="Sylhet">Sylhet</option>
                        </select>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="exprience"><strong>Exprience Time</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="text" name="lawyer_exprience_time" id="exprience" placeholder="About your exprience?*" required>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="say"><strong>Somethings about you</strong></label> -->
                        <textarea class="box-input" type="text" name="lawyer_bio" id="say" placeholder="Bio*" required></textarea>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="consultation"><strong>Consultation time</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="text" name="lawyer_consultation_time" id="consultation" placeholder="Consultation time (4pm-5pm)*" required>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="rof"><strong>Range of fees(Tk)</strong></label> -->
                        <input class="box-input" type="number" name="lawyer_fee" id="rof" placeholder="For one consultation fee (If any)">
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="password"><strong>Password</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="password" name="lawyer_password" id="password" placeholder="Password (Minimum 6 digit)" required>
                    </div>
                    <div class="box-section">
                        <!-- <label class="box-label" for="phone"><strong>Phone Number</strong></label> -->
                        <input class="box-input" type="text" name="lawyer_study_info" id="phone" placeholder="Educational information(study institute etc.)">
                    </div>
                    <div class="box-section">
                        <label class="box-label d-flex" for="certificate"><strong>Certificate</strong> <span class="mendatory">*</span></label>
                        <input class="form-file w-100" type="file" name="lawyer_certificate" id="certificate" required>
                    </div>
                    <div class="box-section">
                        <label class="box-label" for="image"><strong>Photo</strong></label>
                        <input class="form-file w-100" type="file" name="lawyer_image" id="image" placeholder="photo" accept="image/*">
                    </div>
                    <div class="box-section">
                        <label class="box-label" for="gender"><strong>Gender</strong> <span class="mendatory">*</span></label>
                        <div class="radio-area">
                            <div>
                                <label class="cursor-pointer" for="male">Male</label>
                                <input class="cursor-pointer" type="radio" name="lawyer_gender" id="male" value="male">
                            </div>
                            <div>
                                <label class="cursor-pointer" for="female">Female</label>
                                <input class="cursor-pointer" type="radio" name="lawyer_gender" id="female" value="female">
                            </div>
                            <div>
                                <label class="cursor-pointer" for="trans">Trans</label>
                                <input class="cursor-pointer" type="radio" name="lawyer_gender" id="trans" value="transgender">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="checkbox_area mb-3">
                    <label class="cursor-pointer" for="aar"><strong>Accept all rights</strong><span class="mendatory">*</span></label>
                    <input class="cursor-pointer" type="checkbox" name="lawyer_accept" id="aar" value="lawyer accept all" required>
                </div>
                <div class="btn-area">
                    <button class="all-btn" type="submit" name="lawyer_submit">Sing Up</button>
                    <button class="all-btn" type="reset">Reset</button>
                </div>
            </form>
            <div class="go-to-reregiste">have account?<a class="login-reg-btn" href="./login.php">Login</a></div>
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