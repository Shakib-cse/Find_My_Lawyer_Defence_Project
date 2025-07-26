<?php

include('loader.html');

$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "not connected";
}

$passValMsg = $exist_email = $phoneValMsg = '';

if (isset($_POST['lawyer_submit'])) {

    $lawyer_email = $_POST['lawyer_email'];


    $email_select = "SELECT * FROM lawyer_reg WHERE lawyer_email = '$lawyer_email'";
    $exc = mysqli_query($conn, $email_select);
    $count = mysqli_num_rows($exc);

    if ($count > 0) {
        $exist_email = 'This email already exists';
    } else {
        include('./smtp/smtp/PHPMailerAutoload.php');
        $otp = rand(100000, 999999);
        $receivermail = $lawyer_email;
        $subject = "Email varifications";
        $emailbody = "Here is your opt from 'Find My Lawyer' : ";
        echo smtp_mailer($receivermail, $subject, $emailbody . $otp);

            session_start();
            $_SESSION['email_send'] = $lawyer_email;
            $_SESSION['otp_send'] = $otp;
            header("Location: asAlawyer1.php");
            exit();
        }
    }


function smtp_mailer($to, $subject, $msg)
{
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "findmylawyer37@gmail.com";
    $mail->Password = "wamd lneo pval nesz";
    $mail->SetFrom("findmylawyer37@gmail.com");
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => false
        )
    );
    if (!$mail->Send()) {
        echo $mail->ErrorInfo;
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
    <link rel="stylesheet" href="./style/asAlawyer0.css">
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
                    echo "<P class='text-warning fs-3'> $passValMsg </P>";
                }
                if (isset($_POST['lawyer_submit'])) {
                    echo "<P class='text-warning fs-3'> $exist_email </P>";
                }
                if (isset($_POST['lawyer_submit'])) {
                    echo "<P class='text-warning fs-3'> $phoneValMsg </P>";
                }
                ?>
            </span>
        </div>
        <div class="container">
            <h2 class="form-head"><u>SING UP FORM FOR A LAWYER</u></h2>
            <form action="asAlawyer0.php" method="POST">
                <div class="all-form">
                    <div class="box-section">
                        <!-- <label class="box-label" for="email"><strong>Email</strong> <span class="mendatory">*</span></label> -->
                        <input class="box-input" type="email" name="lawyer_email" id="email" placeholder="Email*"
                            required>
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