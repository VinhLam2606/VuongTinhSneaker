<?php
include "connect-db.php";

if (!isset($_GET['st_id'])) {
    echo "Thiếu thông tin sản phẩm.";
    exit;
}

$st_id = (int)$_GET['st_id'];

// Lấy thông tin sản phẩm
$stmt = $db_server->prepare("SELECT st_name, st_gen, st_price, st_image_link FROM shoe_type WHERE st_id = ?");
$stmt->bind_param("i", $st_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Không tìm thấy sản phẩm.";
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();

// Lấy số lượng theo từng size
$stmt = $db_server->prepare("SELECT shoe_size, COUNT(*) as quantity FROM shoe WHERE st_id = ? GROUP BY shoe_size ORDER BY shoe_size ASC");
$stmt->bind_param("i", $st_id);
$stmt->execute();
$size_result = $stmt->get_result();

$sizes = [];
while ($row = $size_result->fetch_assoc()) {
    $sizes[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Sản Phẩm</title>
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/show_shoe_inf.css">

</head>
<body>
    <div class="product-info">
        <img src="<?php echo htmlspecialchars($product['st_image_link']); ?>" alt="Product Image">
        <h2><?php echo htmlspecialchars($product['st_name']); ?></h2>
        <p><strong>Giới tính:</strong> <?php echo htmlspecialchars($product['st_gen']); ?></p>
        <p><strong>Giá:</strong> <?php echo number_format($product['st_price']); ?> VNĐ</p>

        <h3>Số lượng theo từng size</h3>
        <table class="size-table">
            <tr>
                <th>Size</th>
                <th>Số lượng</th>
                <th>Xem chi tiết </th>
            </tr>
            <?php foreach ($sizes as $size): ?>
                <tr>
                    <td><?php echo $size['shoe_size']; ?></td>
                    <td><?php echo $size['quantity']; ?></td>
                    <td>
                        <a href="quantity_detail.php?st_id=<?php echo urlencode($st_id); ?>&shoe_size=<?php echo urlencode($size['shoe_size']); ?>">
                            <img src="/VUONGTINHSNEAKER/images/view.jpg" alt="view" width="20px">
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="shoe-card"  data-id="<?= $st_id?>">
            <button class="change_shoe_btn">Change Product Information</button>
        </div>
        <div class="back-btn">
            <a href="admin_page.php">←</a>
        </div>
    </div>
    
    <script src="/VUONGTINHSNEAKER/scripts/change_delete_shoe.js"></script>
</body>
</html>
