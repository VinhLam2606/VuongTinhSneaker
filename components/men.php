<?php

$isAdmin = isset($_SESSION["user_is_admin"]) ? $_SESSION["user_is_admin"] : 0; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style/footer.css" />
    <link rel="stylesheet" href="../style/navbar.css" />
    <link rel="stylesheet" href="../style/men.css" />
    <script src="https://kit.fontawesome.com/683b4b40e3.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:wght@900&family=Oswald:wght@700&display=swap"
        rel="stylesheet" />
    <title>Vương Tình Sneaker</title>
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
    
    <div id="admin-check" data-isAdmin="<?php echo $isAdmin; ?>"></div>

    <div class="sort-container">
        <label for="sort">Sort by:</label>
        <select id="sort">
            <option value="default">Default</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
            <option value="name_asc">Name: A to Z</option>
            <option value="name_desc">Name: Z to A</option>
        </select>
    </div>

    <div id="shoes-container"></div>
    <div id="pagination"></div>
    <div id="gender-container" data-gender="male" ></div>
    <script src="../scripts/pagination.js"> </script>
    <script src="../scripts/add_to_cart.js"></script>

</body>

</html>
