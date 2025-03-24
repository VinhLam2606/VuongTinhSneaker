<!DOCTYPE html>
<?php
include 'connect-db.php';

$stmt = $db_server->prepare("SELECT * FROM shoe_type"); // Lấy tất cả giày
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