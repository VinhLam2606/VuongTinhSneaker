
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/footer.css">
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/navbar.css">
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/index.css">
    <script src="https://kit.fontawesome.com/683b4b40e3.js" crossorigin="anonymous"></script>
    <link nes="" rel="icon" sizes="128x128" href="images/logo.png">
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:wght@900&family=Oswald:wght@700&display=swap"
        rel="stylesheet">
    <title>Nike, Just Do It. Nike.com</title>
</head>

<body>
    <div id="top_bar">
        <div class="top">
            <?php include 'components/top.php'; ?>
        </div>

        <div class="bottom">
            <?php include 'components/bottom.php'; ?>
        </div>
    </div>

    <?php 
    if (isset($_GET['search']) && !empty($_GET['search'])) { 
    ?>
            <div id="search-results">
                <?php include 'components/search-results.php'; ?>
            </div>
            <script src="scripts/pagination.js"></script>
    <?php
        } else {
    ?>
        <div class="content">
            <?php include 'components/content.php'; ?>
        </div>

        <div class="footer">
            <?php include 'components/footer.php'; ?>
        </div>
    <?php } ?>

    <script> src="scripts/navbar.js" </script>
</html>

