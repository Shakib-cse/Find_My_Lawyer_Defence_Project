
<?php
session_start();

if (isset($_SESSION['selected_slots_count'])) {
    $selected_slots_count = $_SESSION['selected_slots_count'];
}

if (isset($_SESSION['lawyer_fee_data'])) {
    $lawyer_fee_data = $_SESSION['lawyer_fee_data'];
}



$new_ammount = $lawyer_fee_data * $selected_slots_count;


$trans = 'BAE75RC6D9';

if (isset($_POST['payment'])) {
    header('location:user_consulting_time.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bKash Payment Gateway</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Roboto', Times, serif;
        }

        .container-me {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        .bkash-logo {
            width: 80px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
        hr{
            border: 3px solid rgba(221, 22, 99);
        }
        .grid {
	display: grid;
	justify-content: space-between;
	align-items: center;
	gap: 5px;
	grid-template-columns: 1fr 1fr;
    margin-bottom: 30px;
}
.one {
	font-size: 10px;
	display: flex;
	justify-content: center;
	align-items: center;
}

form {
	display: flex;
	flex-direction: column;
	align-items: center;
	gap: 30px;
	background-color: rgba(221, 22, 99);
	padding: 30px;
}
.call{
    color: rgba(221, 22, 99);
    margin-top: 20px;
    font-weight: bold;
}
input{
    outline: none;
}
    </style>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- bootstrap link cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

        <!-- google font cdn -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
</head>
<body>

<div class="container-me">
    <img src="../image/bkash-logo.png" alt="bKash Logo" class="bkash-logo">
    <hr>
    <div class="grid">
        <div class="one"><i class="fa-solid fa-cart-shopping"></i> find my lawyer(marchent account)</div>
        <div class="two"><i class="fa-solid fa-bangladeshi-taka-sign"></i><?php echo $new_ammount; ?></div>
    </div>

    <form action="bkash_payment.php" method="POST">
        <label class="text-white fs-6" for="amount">Your transjection id</label>
        <input class="w-50 rounded-2 p-3 border-0" type="text" id="amount" name="amount" placeholder="Enter transjection id" value="<?php echo $trans ?>" required>


        <button name="payment" type="submit">Proceed</button>
    </form>

    <div class="call"><i class="fa-solid fa-square-phone"></i> 16247</div>
</div>

</body>
</html>
