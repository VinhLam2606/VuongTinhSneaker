<!DOCTYPE html>
<?php
include 'connect-db.php';

// Xử lý sắp xếp
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

switch ($sort) {
    case 'price_asc':
        $orderBy = "ORDER BY st_price ASC";
        break;
    case 'price_desc':
        $orderBy = "ORDER BY st_price DESC";
        break;
    case 'name_asc':
        $orderBy = "ORDER BY st_name ASC";
        break;
    case 'name_desc':
        $orderBy = "ORDER BY st_name DESC";
        break;
    default:
        $orderBy = "";
}

$stmt = $db_server->prepare("SELECT * FROM shoe_type $orderBy");
$stmt->execute();
$result = $stmt->get_result();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/footer.css">
    <link rel="stylesheet" href="../style/login.css">
    <link rel="stylesheet" href="../style/signup.css">
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/men.css">

    <script src="https://kit.fontawesome.com/683b4b40e3.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed:wght@900&family=Oswald:wght@700&display=swap"
        rel="stylesheet">
    <title>Nike, Just Do It. Nike.com</title>
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

    <!-- Sort Dropdown -->
    <div class="sort-container">
        <form method="GET" id="sortForm">
            <label for="sort">Sắp xếp:</label>
            <select name="sort" id="sort" onchange="document.getElementById('sortForm').submit();">
                <option value="default" <?php if ($sort == 'default') echo 'selected'; ?>>Mặc định</option>
                <option value="price_asc" <?php if ($sort == 'price_asc') echo 'selected'; ?>>Giá tăng dần</option>
                <option value="price_desc" <?php if ($sort == 'price_desc') echo 'selected'; ?>>Giá giảm dần</option>
                <option value="name_asc" <?php if ($sort == 'name_asc') echo 'selected'; ?>>Tên A-Z</option>
                <option value="name_desc" <?php if ($sort == 'name_desc') echo 'selected'; ?>>Tên Z-A</option>
            </select>
        </form>
    </div>

    <div id="shoes-container">
        <?php
        while ($row = $result->fetch_assoc()) {
            $name = $row['st_name'];
            $image = $row['st_image_link'];
            $gender = $row['st_gen'];
            $price = $row['st_price'];
        ?>
            <div class="shoe-card">
                <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
                <h2><?php echo $name; ?></h2>
                <p>Giới tính: <?php echo $gender; ?></p>
                <p class="price"><?php echo number_format($price); ?>₫</p>
                <button class="cart-btn">Add to Cart</button>
                <button class="buy-btn">Buy</button>
            </div>
        <?php } ?>
    </div>
</body>

</html>
