<!DOCTYPE html>
<?php
    include 'connect-db.php';

    $record_ppage = 9;

    $page = (isset($_REQUEST["page"])) ? $_REQUEST["page"] : 1;
    if ($page < 1) $page = 1;

    $start =  ($page - 1)*$record_ppage;

    $total_stmt = $db_server->prepare("SELECT COUNT(*) FROM shoe_type");
    $total_stmt->execute();
    $total_stmt->bind_result($total_records);
    $total_stmt->fetch();
    $total_stmt->close();

    $p_total = ceil($total_records/$record_ppage);

    $stmt = $db_server->prepare("SELECT * FROM shoe_type LIMIT ?, ?");
    $stmt->bind_param("ii", $start, $record_ppage);
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

        ?>

            <div class="shoe-card">
                <img src="<?php echo $row['st_image_link']; ?>" alt="<?php echo $row['st_name']; ?>">
                <h2><?php echo $row['st_name']; ?></h2>
                <p>Giới tính: <?php echo $row['st_gen']; ?></p>
                <p class="price"><?php echo number_format($row['st_price']); ?>₫</p>
                <button class="cart-btn">Add to Cart</button>
                <button class="buy-btn">Buy</button>
            </div>
        <?php 
        } ?>
        <div id="pagination">
            <?php
                if ($page > 1) {
            ?>
                 <a href="?page=1">First</a>
                 <a href="?page=<?php echo $page - 1; ?>">&laquo; Prev</a>
            <?php
                }
            ?>

            <span>Page <?php echo $page; ?> of <?php echo $p_total; ?></span>

            <?php if ($page < $p_total) : ?>
            <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
            <a href="?page=<?php echo $p_total; ?>">Last</a>
            <?php endif; ?>
        </div>
    </div>


</body>

</html>