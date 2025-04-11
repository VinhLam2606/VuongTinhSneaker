<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/information.css">
        <title>Vuong Tinh Sneaker</title>
    </head>

    <body>
        <div id="information_box">
            <img src="/VUONGTINHSNEAKER/IMAGES/logo.png" alt="logo" class="logo" width="125">
            <h3>USER INFORMATION</h3>
            <img src="<?php echo $_SESSION['avatar'] ?? '/VUONGTINHSNEAKER/images/default-avatar.png'; ?>" alt="User Avatar" class="avatar">

            <?php
                if (isset($_SESSION['user_email'])) {
                    $phonenumber =  $_SESSION["user_phone_number"] ?? "N/A";
                    $email = $_SESSION['user_email'] ?? "N/A";
                    $firstname = $_SESSION['username'] ?? "N/A";
                    $lastname = $_SESSION['userlastname'] ?? "N/A";
                    $birth = $_SESSION['user_dob'] ?? "N/A";
                    $address = $_SESSION['user_address'] ?? "N/A";
                    $gender = $_SESSION['user_gender'] ?? "N/A";

                    echo "<p><strong>Email:</strong> " . $email . "</p>";
                    echo "<p><strong>Phone Number:</strong> " . $phonenumber . "</p>";
                    echo "<p><strong>Full Name:</strong> " . $firstname . " " . $lastname . "</p>";
                    echo "<p><strong>Birth Date:</strong> " .$birth . "</p>";
                    echo "<p><strong>Address:</strong> " . $address . "</p>";
                    echo "<p><strong>Gender:</strong> " . $gender . "</p>";
                } 
            ?>
            <a href="change_inf.php">
                <button id="change_inf" type="button">Change information</button>
            </a>
            <a href="change_pass.php">
                <button id="change_inf" type="button">Change password</button>
            </a>
            <br>
            <a href="main.php">Back to main page</a>
        </div>
    </body>
</html>
