<?php
$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "Database not connected";
}

session_start();

$current_email = $_SESSION['user_login'];

if (!empty($_SESSION['user_login'])) {
    $_SESSION['user_login'];
} else {
    header('location:../login.php');
}

if (isset($_POST['logout-btn'])) {
    session_destroy();
    header('location:../login.php');
}

$user_sql = "SELECT * FROM user_reg WHERE user_email = '$current_email'";
$user_result = $conn->query($user_sql);
$user_data = $user_result->fetch_assoc();
        $user_image = $user_data["user_image"];





        if (isset($_POST['user_update'])) {
            $user_update_name = $_POST['user_name'];
            $user_update_location = $_POST['user_location'];
        
                $user_update_image = $_FILES['user_update_image']['name'];
                $pp_tmp_name = $_FILES['user_update_image']['tmp_name'];
                $pp_uploc = '../user_img/' . $user_update_image;
        
                move_uploaded_file($pp_tmp_name, $pp_uploc);
        
                $user_update_sql = "UPDATE user_reg SET user_image='$user_update_image', user_name='$user_update_name', user_location='$user_update_location' WHERE user_email='$current_email'";

                if ($conn->query($user_update_sql) === TRUE) {
                    $record_updated = "<script>alert('Update is Successfull!');</script>";
                    header("location:user_profile.php?$user_id");
                } else {
                    $record_updated = "<script>alert('Update is Error!');</script>";
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
    <link rel="stylesheet" href="../style/user_update_one.css">
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
                                <li><a class="header-list" href="#contact"><b>Contact</b></a></li>
                                <li><a class="header-list" href="#" onclick="viewSearchArea()"><i
                                            class="fa-solid fa-magnifying-glass"></i></a></li>
                                <li class="ms-3"><a class="pp_area" href="#">
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
    <main>
        <div class="update-area">
            <div class="container overflow-hidden">
                <div class="update-item text-center">
                    <form action="user_update_one.php" method="POST" enctype="multipart/form-data">
                        <div class="item mb-3">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="user_name">User Name</label>
                            <input class="w-100 p-2 border-0 rounded text-center" type="text" id="user_name" name="user_name" value="<?php echo $user_data['user_name'];?>">
                        </div>
                        <div class="item mb-3">
                            <label class="d-block fs-5 text-decoration-underline mb-1 fw-bold" for="user_location">User Location</label>
                            <input class="w-100 p-2 border-0 rounded text-center" type="text" id="user_location" name="user_location" value="<?php echo $user_data['user_location'];?>">
                        </div>
                        <div class="item mb-3">
                            <label class="fs-5 text-decoration-underline fw-bold" for="user_image">User Image:</label>
                            <input class="ms-1" type="file" id="user_image" name="user_update_image"  accept="image/*">
                        </div>
                        <button class="btn bg-success text-light mt-3" name="user_update">Update</button>
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