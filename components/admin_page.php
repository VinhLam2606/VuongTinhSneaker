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
    <title>Vuong Tinh Sneaker</title>
</head>
<?php
$search_query = isset($_GET['query']) ? $_GET['query'] : '';
?>

<body>
    <div id="top_bar">
        <div class="top">
            <?php include 'top.php'; ?>
        </div>
    </div>


    <div class="sort-admin-container">
        <form method="GET" action="<?php echo htmlspecialchars('admin_page.php'); ?>">
            <div class="search-admin">
                <i id="icon" class="fas fa-search" style="color: black;"></i>
                <input id="search_input" type="text" name="query" placeholder="Search"
                    value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" style="display: none;">Search</button>
            </div>
        </form>

        <label for="sort">Sort by:</label>
        <select id="sort">
            <option value="default">Default</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
            <option value="name_asc">Name: A to Z</option>
            <option value="name_desc">Name: Z to A</option>
        </select>
        <button class="add-product">Add Product </button>
    </div>

    <div id="shoes-container"></div>
    <div id="pagination"></div>
    <div id="gender-container"
        data-gender=""
        data-admin="<?php echo isset($_SESSION["user_is_admin"]) ? $_SESSION["user_is_admin"] : 0; ?>">
    </div>
    <script src="/VUONGTINHSNEAKER/scripts/pagination.js"> </script>
    <script src="/VUONGTINHSNEAKER/scripts/add_product.js"> </script>
    <script src="/VUONGTINHSNEAKER/scripts/change_delete_shoe.js"></script>
</body>

</html>