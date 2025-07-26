<?php

include('loader.html');

$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "Database not connected";
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $suggestion = $_POST['suggestion'];

    $sql = "INSERT INTO suggestion_box (name,email,suggestion) VALUES('$name','$email','$suggestion')";

    if ($conn->query($sql) == TRUE) {
        echo "<script>alert('SUGGESTION RECORDED!');</script>";
    } else {
        echo "<script>alert('SUGGESTION IS ERROR!');</script>";
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
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <header>
        <div class="header-area pt-2 pb-2">
        <div id="clock"></div>
            <div class="container">
                <div class="header-item">
                    <div class="logo-area">
                        <a href="./index.php" class="logo">
                            <img class="rounded-2 me-3" src="./image/logo_transparentN.jpg" alt="" width="90px"
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
                                <li><a href="./login.php"><b>Login/Registratation</b></a></li>
                                <li><a target="_blank" href="http://bdlaws.minlaw.gov.bd/"><b>All law in
                                            Bangladesh</b></a></li>
                                <li><a href="#contact"><b>Contact</b></a></li>
                                <li><a href="#" onclick="viewSearchArea()"><i
                                            class="fa-solid fa-magnifying-glass"></i></a></li>
                                <li>
                                    <form id="search-form" method="GET" action="lawyer_list.php">
                                        <input class="text-black" type="text" name="searchQuery" placeholder="Search...">
                                        <button class="text-black" type="submit">Search</button>
                                    </form>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header> <!-- header area end -->
    <main>
        <div id="hero-area">
            <div class="slides">
                <div class="slide"><img src="./image/img1.jpg" alt="Slide 1"></div>
                <div class="slide"><img src="./image/img2.jpg" alt="Slide 2"></div>
                <div class="slide"><img src="./image/img3.jpg" alt="Slide 3"></div>
                <div class="slide"><img src="./image/img4.jpg" alt="Slide 1"></div>
                <div class="slide"><img src="./image/img5.jpg" alt="Slide 2"></div>
                <div class="slide"><img src="./image/img6.jpg" alt="Slide 3"></div>
                <div class="slide"><img src="./image/img7.jpg" alt="Slide 1"></div>
                <div class="slide"><img src="./image/img8.jpg" alt="Slide 2"></div>
                <div class="slide"><img src="./image/img9.jpg" alt="Slide 3"></div>
                <div class="slide"><img src="./image/img10.jpg" alt="Slide 1"></div>
                <div class="slide"><img src="./image/img11.jpg" alt="Slide 2"></div>
            </div>
            <div class="container">
                <div class="hero-item">
                    <div class="animation">
                        <div class="container">
                            <div class="animation-item">
                                <h2 id="speaker-talk">If you are born poor it's not your mistake, but if you die poor
                                    it's your mistake.</h2>
                                <p id="speaker-name">-Bill Geats</p>
                            </div>
                        </div>
                    </div>
                    <div class="search-area">
                        <div class="container">
                            <div class="search-item" id="search-area">
                                <span class="search-cross"><i class="fa-solid fa-xmark cross" id="cross"></i></span>
                                <h2 class="mb-5"><b><u>It will make easy to find your lawyer</u></b></h2>
                                <form action="lawyer_list.php" method="POST">
                                    <div class="search-item-all">
                                        <label for="">Which area you need lawyer?</label>
                                        <select name="select_location">
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
                                    <div class="search-item-all">
                                        <button type="submit" name="show_lawyer" class="all-btn">FIND MY LAWYER <i
                                                class="fa-solid fa-angle-right"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- hero and search area end -->
        <div class="lawyer-list-area">
            <div class="container">
                <h1 class="text-black mb-5 text-center text-decoration-underline">Lawyer in Focus</h1>
                <div class="lawyer-item">
                    <div class="lawyer-card">
                        <img class="lawyer-img" src="./focus_lawyer_image/BARRISTER-MITI-SANJANA.jpg" alt="photo">
                        <h3 class="lawyer-name">Barrister Miti Sanjana</h3>
                        <p class="lawyer-title">Barrister</p>
                        <button class="all-btn" onclick="loginAlert()">View Profile</button>
                    </div>
                    <div class="lawyer-card">
                        <img class="lawyer-img" src="./focus_lawyer_image/BARRISTER-OMAR-H-KHAN.jpg" alt="photo">
                        <h3 class="lawyer-name">Barrister omar khan</h3>
                        <p class="lawyer-title">Barrister</p>
                        <button class="all-btn" onclick="loginAlert()">View Profile</button>
                    </div>
                    <div class="lawyer-card">
                        <img class="lawyer-img" src="./focus_lawyer_image/Barrister-Mehzabin-Khan.jpg" alt="photo">
                        <h3 class="lawyer-name">Barrister mehzabin khan</h3>
                        <p class="lawyer-title">Barrister</p>
                        <button class="all-btn" onclick="loginAlert()">View Profile</button>
                    </div>
                    <div class="lawyer-card">
                        <img class="lawyer-img" src="./focus_lawyer_image/BARRISTER-MOHAMMAD-SHAHRUKH-SADEK.jpg" alt="photo">
                        <h3 class="lawyer-name">Barrister Shahrukh sadek</h3>
                        <p class="lawyer-title">Barrister</p>
                        <button class="all-btn" onclick="loginAlert()">View Profile</button>
                    </div>
                    <!-- <div class="lawyer-card">
                        <img class="lawyer-img" src="./focus_lawyer_image/Sharif-Bhuiyan-1.png" alt="photo">
                        <h3 class="lawyer-name">Sharif Bhuiyan</h3>
                        <p class="lawyer-title">Dr Kamal Hossain & Associates</p>
                        <button class="all-btn" onclick="loginAlert()">View Profile</button>
                    </div> -->
                </div>
            </div>
        </div> <!-- lawyer list area end -->
        <div class="division-name-area">
            <div class="container">
                <h1 class="text-white mb-5 text-center text-decoration-underline">Speciality of Lawyer</h1>
                <div class="division-item">
                    <div class="division">
                        <a href="#" class="capital" onclick="loginAlert()">Family</a>
                    </div>
                    <div class="division">
                        <a href="#" class="capital" onclick="loginAlert()">Crime</a>
                    </div>
                    <div class="division">
                        <a href="#" class="capital" onclick="loginAlert()">Immigration</a>
                    </div>
                    <div class="division">
                        <a href="#" class="capital" onclick="loginAlert()">Tax</a>
                    </div>
                    <div class="division">
                        <a href="#" class="capital" onclick="loginAlert()">Commercial</a>
                    </div>
                    <div class="division">
                        <a href="#" class="capital" onclick="loginAlert()">Divorce</a>
                    </div>
                    <div class="division">
                        <a href="#" class="capital" onclick="loginAlert()">Accident</a>
                    </div>
                    <div class="division">
                        <a href="#" class="capital" onclick="loginAlert()">Banking Law</a>
                    </div>
                </div>
            </div>
        </div> <!-- lawyer area name area end -->
        <div class="suggestion-area">
            <div class="container">
                <h1 class="text-black mb-5 text-decoration-underline">Suggestion box</h1>
                <div class="sec">
                    <div class="sec-1">
                        <form action="index.php" method="POST" class="suggestion-item">
                            <div class="suggestion-form">
                                <label for="s-name">Name</label>
                                <input type="text" id="s-name" name="name">
                            </div>
                            <div class="suggestion-form">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email">
                            </div>
                            <div class="suggestion-form">
                                <label for="sugg">Write your suggestion for us</label>
                                <textarea name="suggestion" id="sugg" cols="30" rows="10"></textarea>
                            </div>
                            <button type="submit" name="submit" class="all-btn">Submit</button>
                        </form>
                    </div>
                    <div class="sec-2">
                        <img src="./image/pexels-sora-shimazaki-5669602.jpg" alt="image">
                    </div>
                </div>
            </div>
        </div> <!-- suggestion area end -->
    </main>
    <footer>
        <div class="upper-area" id="contact">
            <div class="container">
                <h1 class="mb-5 text-decoration-underline">Contact information</h1>
                <div class="upper-item">
                    <div class="upper-item-1">
                        <div class="upper-item-1-all">
                            <span class="fs-3">Email:</span>
                            <a href="mailto:findmylawyer37@gmail.com">findmylawyer37@gmail.com</a>
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

    <script src="./script/script.js"></script>
</body>

</html>