<?php
session_start();
include "connect-db.php";

// Xử lý thêm mới số lượng giày
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_btn'])) {
    $add_st_id = intval($_POST['add_st_id']);
    $add_size = intval($_POST['add_shoe_size']);
    $add_quantity = intval($_POST['add_quantity']);

    if ($add_quantity > 0) {
        for ($i = 0; $i < $add_quantity; $i++) {
            $stmt = $db_server->prepare("INSERT INTO shoe (st_id, shoe_size) VALUES (?, ?)");
            $stmt->bind_param("ii", $add_st_id, $add_size);
            $stmt->execute();
            $stmt->close();
        }
        echo "<script>alert('Added successfully!'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Please enter a valid quantity.');</script>";
    }
}

// Xử lý xóa giày
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_shoe_id'])) {
    $shoe_id_to_delete = intval($_POST['delete_shoe_id']);
    $stmt = $db_server->prepare("DELETE FROM shoe WHERE shoe_id = ?");
    $stmt->bind_param("i", $shoe_id_to_delete);

    if ($stmt->execute()) {
        echo "<script>alert('Deleted successfully'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Delete failed');</script>";
    }
    $stmt->close();
}

// Lấy thông tin sản phẩm từ URL
if (isset($_GET['st_id']) && isset($_GET['shoe_size'])) {
    $st_id = intval($_GET['st_id']);
    $shoe_size = intval($_GET['shoe_size']);

    $stmt = $db_server->prepare("SELECT st_name FROM shoe_type WHERE st_id = ?");
    $stmt->bind_param("i", $st_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Product not found.";
        exit;
    }

    $shoe_type = $result->fetch_assoc();
    $stmt->close();

    // Lấy danh sách shoe_id
    $stmt = $db_server->prepare("SELECT shoe_id FROM shoe WHERE st_id = ? AND shoe_size = ?");
    $stmt->bind_param("ii", $st_id, $shoe_size);
    $stmt->execute();
    $result = $stmt->get_result();

    $shoe_ids = [];
    while ($row = $result->fetch_assoc()) {
        $shoe_ids[] = $row['shoe_id'];
    }

    $quantity = count($shoe_ids);
    $stmt->close();
} else {
    echo "Missing parameters.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vuong Tinh Sneaker</title>
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/quantity_detail.css">
</head>
<body>
    <div class="detail-box">
        <h2>Shoe Quantity Details</h2>
        <p class="info"><strong>Product Name:</strong> <?php echo htmlspecialchars($shoe_type['st_name']); ?></p>
        <p class="info"><strong>Size:</strong> <?php echo htmlspecialchars($shoe_size); ?></p>
        <p class="info"><strong>Total Quantity:</strong> <?php echo $quantity; ?></p>

        <form method="POST" class="add-form" onsubmit="return confirm('Add new shoes?');">
            <input type="hidden" name="add_st_id" value="<?php echo $st_id; ?>">
            <input type="hidden" name="add_shoe_size" value="<?php echo $shoe_size; ?>">
            <input type="number" name="add_quantity" placeholder="Quantity to add" min="1" required>
            <button type="submit" name="add_btn" class="add-btn">Thêm</button>
        </form>

        <?php if ($quantity > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Shoe ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shoe_ids as $index => $id): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $id; ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete shoe ID <?php echo $id; ?>?');">
                                    <input type="hidden" name="delete_shoe_id" value="<?php echo $id; ?>">
                                    <button type="submit" class="delete-btn">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No shoes available in this size.</p>
        <?php endif; ?>

        <div class="back-btn">
            <a href="show_shoe_inf.php?st_id=<?php echo urlencode($st_id); ?>">←</a>
        </div>
    </div>
</body>
</html>
