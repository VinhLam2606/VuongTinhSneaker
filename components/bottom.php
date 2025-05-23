<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/683b4b40e3.js" crossorigin="anonymous"></script>
    <link nes="" rel="icon" sizes="120x128" href="images/logo.png">
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:wght@900&family=Oswald:wght@700&display=swap"
        rel="stylesheet">
    <title>Vuong Tinh Sneaker</title>
</head>
<?php
$search_query = isset($_GET['query']) ? $_GET['query'] : '';
?>

<body>
    <div id="bottom">
        <div class="left">
            <a href="/VuongTinhSneaker/components/main.php">
                <img src="/VUONGTINHSNEAKER/images/logo.png" alt="Vuong Tinh Logo" height="60px" width="75px">
            </a>

        </div>
        <div id="center_phone">
        </div>
        <div class="center">
            <a href="/VuongTinhSneaker/components/men.php" class="nav-link"><b>Men</b></a>
            <a href="/VuongTinhSneaker/components/women.php" class="nav-link"><b>Women</b></a>
        </div>

        <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="search">
                <i id="icon" class="fas fa-search"></i>
                <input id="search_input" type="text" name="query" placeholder="Search"
                    value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" style="display: none;">Search</button>
            </div>
        </form>

        <div class="right">
            <a href="/VuongTinhSneaker/components/cart.php">
                <svg width="30px" height="30px" viewBox="0 0 24 24">
                    <path d="M16 7a1 1 0 0 1-1-1V3H9v3a1 1 0 0 1-2 0V3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v3a1 1 0 0 1-1 1z"></path>
                    <path d="M20 5H4a2 2 0 0 0-2 2v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a2 2 0 0 0-2-2zm0 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7h16z"></path>
                </svg>
            </a>
        </div>
    </div>
    <div class="text">

    </div>
</body>

</html>