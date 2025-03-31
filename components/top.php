<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/footer.css">
    <link rel="stylesheet" href="./style/login.css">
    <link rel="stylesheet" href="./style/signup.css">
    <link rel="stylesheet" href="./style/navbar.css">
    <link rel="stylesheet" href="./style/index.css">
    <script src="https://kit.fontawesome.com/683b4b40e3.js" crossorigin="anonymous"></script>
    <link nes="" rel="icon" sizes="128x128" href="images/logo.png">
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:wght@900&family=Oswald:wght@700&display=swap"
        rel="stylesheet">
    <title>Nike, Just Do It. Nike.com</title>
</head>

<body>
    <?php
        session_start();
    ?>
    <div id="top">
        <div id="right">
            <p>Help</p>
            <?php if (isset($_SESSION["user_id"])): ?>
                <div class="user-info">
                    <img src="<?php echo $_SESSION['avatar']; ?>" alt="User Avatar" class="avatar">
                   <a href="/VUONGTINHSNEAKER/components/information.php"> <span><?php echo $_SESSION['username']; ?></span> </a>
                    <a href="/VUONGTINHSNEAKER/components/logout.php" class="logout-btn">Log out</a>
                </div>
            <?php else: ?>
                <p id="join_us_nav_bar"><a href="/VUONGTINHSNEAKER/components/signup.php">Join Us</a></p>
                <hr>
                <p id="sign_in_nav_bar"><a href="/VUONGTINHSNEAKER/components/login.php">Sign In</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>

</html>