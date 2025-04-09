<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/footer.css">
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/navbar.css">
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/index.css">
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/men.css">
    <script src="https://kit.fontawesome.com/683b4b40e3.js" crossorigin="anonymous"></script>
    <link rel="icon" sizes="128x128" href="images/logo.png">
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:wght@900&family=Oswald:wght@700&display=swap"
        rel="stylesheet">
    <title>Vuong Tinh Sneaker</title>
</head>

<body>
    <div id="top_bar">
        <div class="top">
            <?php include 'top.php'; ?>
        </div>

        <div class="bottom">
            <?php include 'bottom.php'; ?>
        </div>
    </div>

    <?php 
    if (isset($_GET['query']) && !empty($_GET['query'])) { 
        include 'load_shoes.php';
    }  else {
    ?>
        <div class="content">
            <?php include 'content.php'; ?>
        </div>

        <div class="footer">
            <?php include 'footer.php'; ?>
        </div>
    <?php } ?>

    <div id="gender-container" data-gender=""></div>
    <script src="../scripts/pagination.js"></script>
    <script src="../scripts/add_to_cart.js"></script>
    <script src="./scripts/navbar.js"></script>

</body>
</html>
