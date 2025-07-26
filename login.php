<?php

include('loader.html');

session_start();

$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "Database not connected";
}

// lawyer area start
if (isset($_POST['lawyer_submit'])) {
    $lawyer_email= $_POST['lawyer_email'];
    $lawyer_password = $_POST['lawyer_password'];
    $lawyer_md5_pass = md5($lawyer_password);

    if($lawyer_email=="admin@gmail.com" && $lawyer_password=="admin"){
        header('location:admin/admin.php');
    }

    $lawyer_sql = "SELECT * from lawyer_reg WHERE lawyer_email = '$lawyer_email' AND lawyer_md5_pass = '$lawyer_md5_pass'";

    $lawyer_query = $conn->query($lawyer_sql);

    if ($lawyer_query->num_rows > 0) {
        $_SESSION['lawyer_login'] = $lawyer_email;
        header('location:lawyer_after_login/afterLoginLawyer.php');
    } else {
        $lawyer_notification = 'Incorrect Information';
    }
}
// lawyer area end


// user area start
if (isset($_POST['user_submit'])) {
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_md5_pass = md5($user_password);

    if($user_email=="admin@gmail.com" && $user_password=="admin"){
        header('location:admin/admin.php');
    }

    $user_sql = "SELECT * from user_reg WHERE user_email = '$user_email' AND user_md5_pass = '$user_md5_pass'";

    $user_query = $conn->query($user_sql);

    if ($user_query-> num_rows > 0) {
        $_SESSION['user_login'] = $user_email;
        header('location:user_after_login/afterLoginUser.php');
    } else {
        $user_notification = 'Incorrect Information';
    }
}
// user area end

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
    <link rel="stylesheet" href="./style/login.css">
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
                if (isset($_POST['lawyer_submit'])) {
                    echo "<P class='text-warning fs-3'> $lawyer_notification </P>";
                }
                if (isset($_POST['user_submit'])) {
                    echo "<P class='text-warning fs-3'> $user_notification </P>";
                }
                if (isset($_GET['lawyercreated'])) {
                    echo "<p class='text-success fs-3'> Lawyer Registration was successful </p>";
                }
                if (isset($_GET['usercreated'])) {
                    echo "<p class='text-success fs-3'> User Registration was successful </p>";
                }
                ?>
            </span>
        </div>

        <div class="login-area">
            <div class="for-lawyer-area">
                <div class="container">
                    <h2 class="form-head"><u>LOGIN FOR LAWYER</u></h2>
                    <form action="login.php" method="POST">
                        <span class="all-error"></span>
                        <div class="box-section">
                            <label class="box-label" for="email"><strong>Email</strong></label>
                            <input class="box-input" type="email" name="lawyer_email" required>
                        </div>
                        <div class="box-section">
                            <label class="box-label" for="password"><strong>Password</strong></label>
                            <input class="box-input" type="password" name="lawyer_password" required>
                        </div>
                        <div class="btn-area">
                            <button class="all-btn" type="submit" name="lawyer_submit">Login</button>
                            <button class="all-btn" type="reset">Reset</button>
                        </div>
                    </form>
                    <div class="go-to-reregiste">
                        Not any account?<a class="login-reg-btn" href="./asAlawyer0.php">Lawyer Registration</a>
                    </div>
                </div>
            </div> <!-- lawyer login end -->
            <div class="for-user-area">
                <div class="container">
                    <h2 class="form-head"><u>LOGIN FOR USER</u></h2>
                    <form action="login.php" method="POST">
                        <span class="all-error"></span>
                        <div class="box-section">
                            <label class="box-label" for="email"><strong>Email</strong></label>
                            <input class="box-input" type="email" name="user_email" required>
                        </div>
                        <div class="box-section">
                            <label class="box-label" for="password"><strong>Password</strong></label>
                            <input class="box-input" type="password" name="user_password" required>
                        </div>
                        <div class="btn-area">
                            <button class="all-btn" type="submit" name="user_submit">Login</button>
                            <button class="all-btn" type="reset">Reset</button>
                        </div>
                    </form>
                    <div class="go-to-reregiste">
                        Not any account?<a class="login-reg-btn" href="./asAuser0.php">User Registration</a>
                    </div>
                </div>
            </div> <!-- user login end -->
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            document.getElementById('preloader').style.display = 'flex';
        });
    });

    window.addEventListener('load', function () {
        document.getElementById('preloader').style.display = 'none';
    });
});

    </script>
</body>

</html>