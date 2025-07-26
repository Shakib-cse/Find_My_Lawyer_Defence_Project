<?php
$conn = new mysqli('localhost', 'root', '', 'findmylawyerdb');
if (!$conn) {
    echo "Database not connected";
}

session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");


$lawyer_show_data = $location_value = '';

//location search
if (isset($_POST['show_lawyer'])) {
    $location_value = $_POST['select_location'];
}

$lawyer_show_sql = "SELECT * FROM lawyer_reg WHERE lawyer_prectice_location = '$location_value'";
$lawyer_show_result = $conn->query($lawyer_show_sql);



// logout section
if (isset($_POST['logout-btn'])) {
    session_destroy();
    header('location:../login.php');
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
    <link rel="stylesheet" href="../style/login_lawyer_list.css">
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
                                        <form action="lawyerLIst.php" method="POST"><button
                                                class="header-list border-0" name="logout-btn"><b
                                                    class="text-danger">Logout</b></button></form>
                                    </a></li>
                                    <li class="position-relative"><a class="header-list" href="user_consulting_time.php"><b>Request</b><span class="request-number" id="request-number"><i class="fa-solid fa-bell"></i></span></a></li>
                                <li class="me-2"><a class="header-list" href="#contact"><b>Contact</b></a></li>
                                    <form id="search-form" method="GET" action="lawyerList.php">
                                        <input class="text-black" type="text" name="searchQuery"
                                            placeholder="Search..." id="search_lawyer" required>
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
    <main style="padding-top:150px;padding-bottom:100px;background:wheat;">
        <div class="lawyer_area">
            <div class="container">
            <div class="filter-search">
                    <button class="filter-btn p-2 rounded-2 bg-success mb-2 cursor-pointer border-0 text-light" onclick="toggleSection()">Filter</button>
                    <div class="filter-item hidden pb-3 text-center" id="filter-item">
                    <form action="lawyerLIst.php" method="post">
        <input class="bg-secondary p-1 rounded-2 border-0 me-2" type="number" name="feeRange" id="fee-range" placeholder="Fee Max. Range(in tk.)">

        <input class="bg-secondary p-1 rounded-2 border-0 me-2" class="text-black" type="text" name="title" id="title" placeholder="Title of Lawyer">

        <select class="p-1 rounded-2 border-0 bg-secondary me-2" name="gender" id="gender">
            <option value="">All</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="trans">Other</option>
        </select>

        <input class="p-1 rounded-2 border-0 bg-secondary" class="text-black" type="text" name="location" id="location" placeholder="Location">
        <br>

        <button class="mt-2 border-0 bg-success p-2 rounded-2" type="submit">Apply Filters</button>
    </form>
                    </div>
                </div>
                <div class="lawyer-item">
                    <?php
                    if ($lawyer_show_result->num_rows > 0) {
                        while ($lawyer_show_data = $lawyer_show_result->fetch_assoc()) {
                            $imagePath = $lawyer_show_data['lawyer_image'];

                            if ($imagePath) { // location search
                                echo "<form action='lawyer_profile.php' method='POST'><div class='lawyer-card'>
                                <img class='lawyer-img' src='../lawyer_img/$imagePath' alt='photo'>
                                <h3 class='lawyer-name'>" . $lawyer_show_data['lawyer_name'] . "</h3>
                                <h4 class='lawyer-title'>" . $lawyer_show_data['lawyer_title'] . "</h4>
                                <p class='lawyer-location'>Work Area: " . $lawyer_show_data['lawyer_prectice_location'] . "</p>
                                <p class='lawyer-price'>Fee: " . $lawyer_show_data['lawyer_fee'] . " tk</p>

                        <input type='hidden' name='lawyer_name' value='" . $lawyer_show_data['lawyer_name'] . "'>
                        <input type='hidden' name='lawyer_title' value='" . $lawyer_show_data['lawyer_title'] . "'>
                        <input type='hidden' name='lawyer_location' value='" . $lawyer_show_data['lawyer_prectice_location'] . "'>
                        <input type='hidden' name='lawyer_bio' value='" . $lawyer_show_data['lawyer_bio'] . "'>

                        <button type='submit' class='all-btn' name='get_lawyer_info'>View Profile</button>
                                </div></form>";
                            } else {
                                echo "<form action='lawyer_profile.php' method='POST'><div class='lawyer-card'>
                                <img class='lawyer-img' src='../none image/none-img.webp' alt='photo'>
                                <h3 class='lawyer-name'>" . $lawyer_show_data['lawyer_name'] . "</h3>
                                <h4 class='lawyer-title'>" . $lawyer_show_data['lawyer_title'] . "</h4>
                                <p class='lawyer-location'>Work Area: " . $lawyer_show_data['lawyer_prectice_location'] . "</p>
                                <p class='lawyer-price'>Fee: " . $lawyer_show_data['lawyer_fee'] . " tk</p>
                                <p class='lawyer-bio d-none'>" . $lawyer_show_data['lawyer_bio'] . "</p>
                                
                                <input type='hidden' name='lawyer_name' value='" . $lawyer_show_data['lawyer_name'] . "'>
                        <input type='hidden' name='lawyer_title' value='" . $lawyer_show_data['lawyer_title'] . "'>
                        <input type='hidden' name='lawyer_location' value='" . $lawyer_show_data['lawyer_prectice_location'] . "'>
                        <input type='hidden' name='lawyer_bio' value='" . $lawyer_show_data['lawyer_bio'] . "'>

                        <button type='submit' class='all-btn' name='get_lawyer_info'>View Profile</button>
                                </div></form>";
                            }


                        }
                    } elseif (isset($_GET['searchQuery'])) { //write search
                            $searchQuery = mysqli_real_escape_string($conn, $_GET['searchQuery']);

                            $query = "SELECT * FROM lawyer_reg WHERE lawyer_prectice_area LIKE '%$searchQuery%' OR lawyer_prectice_location LIKE '%$searchQuery%' OR lawyer_name LIKE '%$searchQuery%'";
                            $result = mysqli_query($conn, $query);

                            $searchResults = [];
                            while ($row = mysqli_fetch_assoc($result)) {
                                $searchResults[] = $row;
                            }

                            if (empty($searchResults)) {
                                echo "<h3 class='text-black'>No result found.</h3>";
                            } else {
                                foreach ($searchResults as $result) {
                                    $search_image = $result['lawyer_image'];

                                    if ($search_image) {
                                        echo "<form action='lawyer_profile.php' method='POST'><div class='lawyer-card'>
                                        <img class='lawyer-img' src='../lawyer_img/$search_image' alt='photo'>
                                        <h3 class='lawyer-name'>" . $result['lawyer_name'] . "</h3>
                                        <h4 class='lawyer-title'>" . $result['lawyer_title'] . "</h4>
                                        <p class='lawyer-location'>Work Area: " . $result['lawyer_prectice_location'] . "</p>
                                        <p class='lawyer-price'>Fee: " . $result['lawyer_fee'] . " tk</p>
        
                                <input type='hidden' name='lawyer_name' value='" . $result['lawyer_name'] . "'>
                                <input type='hidden' name='lawyer_title' value='" . $result['lawyer_title'] . "'>
                                <input type='hidden' name='lawyer_location' value='" . $result['lawyer_prectice_location'] . "'>
                                <input type='hidden' name='lawyer_bio' value='" . $result['lawyer_bio'] . "'>
        
                                <button type='submit' class='all-btn' name='get_lawyer_info'>View Profile</button>
                                        </div></form>";
                                    } else {
                                        echo "<form action='lawyer_profile.php' method='POST'><div class='lawyer-card'>
                                        <img class='lawyer-img' src='../none image/none-img.webp' alt='photo'>
                                        <h3 class='lawyer-name'>" . $result['lawyer_name'] . "</h3>
                                        <h4 class='lawyer-title'>" . $result['lawyer_title'] . "</h4>
                                        <p class='lawyer-location'>Work Area: " . $result['lawyer_prectice_location'] . "</p>
                                        <p class='lawyer-price'>Fee: " . $result['lawyer_fee'] . " tk</p>
                                        <p class='lawyer-bio d-none'>" . $result['lawyer_bio'] . "</p>
                                        
                                        <input type='hidden' name='lawyer_name' value='" . $result['lawyer_name'] . "'>
                                <input type='hidden' name='lawyer_title' value='" . $result['lawyer_title'] . "'>
                                <input type='hidden' name='lawyer_location' value='" . $result['lawyer_prectice_location'] . "'>
                                <input type='hidden' name='lawyer_bio' value='" . $result['lawyer_bio'] . "'>
        
                                <button type='submit' class='all-btn' name='get_lawyer_info'>View Profile</button>
                                        </div></form>";
                                    }
                                }
                            }
                    }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') { //filter search
                        $feeRange = mysqli_real_escape_string($conn, $_POST['feeRange']);
                        $title = mysqli_real_escape_string($conn, $_POST['title']);
                        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
                        $location = mysqli_real_escape_string($conn, $_POST['location']);
                    
                        $filter_sql = "SELECT * FROM lawyer_reg WHERE 1";
                    
                        if (!empty($feeRange)) {
                            $filter_sql .= " AND lawyer_fee <= '$feeRange'";
                        }
                        if (!empty($feeRange == '0')) {
                            $filter_sql .= " AND lawyer_fee = '$feeRange'";
                        }
                    
                        if (!empty($title)) {
                            $filter_sql .= " AND lawyer_title = '$title'";
                        }
                    
                        if (!empty($gender)) {
                            $filter_sql .= " AND lawyer_gender = '$gender'";
                        }
                    
                        if (!empty($location)) {
                            $filter_sql .= " AND lawyer_prectice_location = '$location'";
                        }
                    
                        $result = mysqli_query($conn, $filter_sql);
                    
                        if (mysqli_num_rows($result) == 0) {
                            echo "No results found.";
                        } else {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $filter_image = $row['lawyer_image'];

                                if ($filter_image) {
                                    echo "<form action='lawyer_profile.php' method='POST'><div class='lawyer-card'>
                                    <img class='lawyer-img' src='../lawyer_img/$filter_image' alt='photo'>
                                    <h3 class='lawyer-name'>" . $row['lawyer_name'] . "</h3>
                                    <h4 class='lawyer-title'>" . $row['lawyer_title'] . "</h4>
                                    <p class='lawyer-location'>Work Area: " . $row['lawyer_prectice_location'] . "</p>
                                    <p class='lawyer-price'>Fee: " . $row['lawyer_fee'] . " tk</p>
    
                            <input type='hidden' name='lawyer_name' value='" . $row['lawyer_name'] . "'>
                            <input type='hidden' name='lawyer_title' value='" . $row['lawyer_title'] . "'>
                            <input type='hidden' name='lawyer_location' value='" . $row['lawyer_prectice_location'] . "'>
                            <input type='hidden' name='lawyer_bio' value='" . $row['lawyer_bio'] . "'>
    
                            <button type='submit' class='all-btn' name='get_lawyer_info'>View Profile</button>
                                    </div></form>";
                                } else {
                                    echo "<form action='lawyer_profile.php' method='POST'><div class='lawyer-card'>
                                    <img class='lawyer-img' src='../none image/none-img.webp' alt='photo'>
                                    <h3 class='lawyer-name'>" . $row['lawyer_name'] . "</h3>
                                    <h4 class='lawyer-title'>" . $row['lawyer_title'] . "</h4>
                                    <p class='lawyer-location'>Work Area: " . $row['lawyer_prectice_location'] . "</p>
                                    <p class='lawyer-price'>Fee: " . $row['lawyer_fee'] . " tk</p>
                                    <p class='lawyer-bio d-none'>" . $row['lawyer_bio'] . "</p>
                                    
                                    <input type='hidden' name='lawyer_name' value='" . $row['lawyer_name'] . "'>
                            <input type='hidden' name='lawyer_title' value='" . $row['lawyer_title'] . "'>
                            <input type='hidden' name='lawyer_location' value='" . $row['lawyer_prectice_location'] . "'>
                            <input type='hidden' name='lawyer_bio' value='" . $row['lawyer_bio'] . "'>
    
                            <button type='submit' class='all-btn' name='get_lawyer_info'>View Profile</button>
                                    </div></form>";
                                }
                            }
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </main> <!-- lawyer list area end -->
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

    <script src="../script/login_lawyer_list.js"></script>
</body>

</html>