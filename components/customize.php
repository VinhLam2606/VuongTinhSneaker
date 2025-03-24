<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customise</title>
    <link nes="" rel="icon" sizes="128x128" href="https://www.nike.com/android-icon-128x128.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/customize.css">
    <link rel="stylesheet" href="../style/footer.css">
    <script src="https://kit.fontawesome.com/683b4b40e3.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar -->
    <div id="bottom">
        <div class="left">
            <a href="../index.html">
                <img src="images/logo.png" alt="Vuong Tinh Logo" height="60px" width="120px">
            </a>

        </div>
        <div id="center_phone">
        </div>
        <div class="center" style="color: rgb(237, 115, 204);">
            <a href="components/men.php" class="nav-link">Men</a>
            <a href="components/women.php" class="nav-link">Women</a>
            <a href="components/kid.php" class="nav-link">Kid</a>
            <a href="components/customize.php" class="nav-link">Customize</a>
            <a href="components/sales.php" class="nav-link">Sale</a>
            <a href="components/feed.php" class="nav-link">Feed</a>
        </div>

        <div class="search">
            <i id="icon" class="fas fa-search" style="color: rgb(237, 115, 204);"></i>
            <input id="search_input" type="text" placeholder="Search">
        </div>
        <div class="right">
            <a href="./Pages/wishlist.html"><i id="hearth" class="far fa-heart" style="color: rgb(237, 115, 204);"></i></a>
            <a href="./Pages/cart.html"><svg width="30px" height="30px" fill="#111" viewBox="0 0 24 24">
                    <path d="M16 7a1 1 0 0 1-1-1V3H9v3a1 1 0 0 1-2 0V3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v3a1 1 0 0 1-1 1z">
                    </path>
                    <path
                        d="M20 5H4a2 2 0 0 0-2 2v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a2 2 0 0 0-2-2zm0 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7h16z">
                    </path>
                </svg></a>
        </div>
    </div>
        <div class="text">

        </div>
    </div>

    <div id="customize_image">
        <p>Nike By You</p>
        <img src="https://i2.paste.pics/1f85e8c4c71e857c50f3ef4551ef3ec7.png?trs=2218877daff98d7db84b885b54f3c3afd8bd8e45259e7205630d3234042c601f" alt="">
    </div>
    <div id="customize_content">
        <h1>PUT MORE YOU IN</h1>
        <h1>YOUR SHOE</h1>
        <p>Whether you make it loud or keep it neutral, customize a shoe that's
            more like you with Nike's co-creation service.
        </p>

        <button>Customise</button>
    </div>

    <div id="customise_footer"></div>
</body>

</html>

<script src="../script/navbar.js"></script>

<script type="module">
    import footer from "../anand footer/footer.js"

    let footer_styles = footer()
    document.querySelector("#customise_footer").innerHTML = footer_styles
</script>