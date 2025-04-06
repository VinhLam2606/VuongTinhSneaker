<?php
session_start();
include "connect-db.php";

// Nếu chưa có st_id trong session, lấy sản phẩm mới nhất từ bảng shoe_type
if (!isset($_SESSION['st_id'])) {
    $result = $db_server->query("SELECT st_id FROM shoe_type ORDER BY st_id DESC LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['st_id'] = $row['st_id'];
    } else {
        die("Không tìm thấy sản phẩm nào. Vui lòng thêm sản phẩm trước.");
    }
}

// Xử lý dữ liệu khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $st_id = $_SESSION['st_id'];

    // Các kích cỡ cố định từ 37 đến 43
    foreach (range(37, 43) as $size) {
        $quantity = isset($_POST['quantity_' . $size]) ? (int)$_POST['quantity_' . $size] : 0;
        for ($i = 0; $i < $quantity; $i++) {
            $stmt = $db_server->prepare("INSERT INTO shoe (st_id, shoe_size) VALUES (?, ?)");
            $stmt->bind_param("ii", $st_id, $size);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Xử lý kích cỡ khác (other)
    $other_size = isset($_POST['other_size']) ? (int)$_POST['other_size'] : 0;
    $other_quantity = isset($_POST['quantity_other']) ? (int)$_POST['quantity_other'] : 0;
    if ($other_size > 0 && $other_quantity > 0) {
        for ($i = 0; $i < $other_quantity; $i++) {
            $stmt = $db_server->prepare("INSERT INTO shoe (st_id, shoe_size) VALUES (?, ?)");
            $stmt->bind_param("ii", $st_id, $other_size);
            $stmt->execute();
            $stmt->close();
        }
    }

    echo "<script>alert('Thêm giày thành công!'); window.location.href='admin_page.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Chi Tiết Giày</title>
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/add_shoe.css">
</head>
<body>
    <div id="add_shoe_box">
        <h3>Thêm Chi Tiết Giày Cho Sản Phẩm Mới</h3>
        <p>Nhập số lượng giày theo các kích cỡ có sẵn từ 37 đến 43 và kích cỡ khác nếu có.</p>
        <form method="POST" action="add_shoe.php">
            <table>
                <tr>
                    <th>Kích cỡ</th>
                    <th>Số lượng</th>
                </tr>
                <?php
                // Hiển thị các dòng cho kích cỡ từ 37 đến 43
                foreach (range(37, 43) as $size) {
                    echo "<tr>
                            <td>$size</td>
                            <td><input type='number' name='quantity_$size' min='0' value='0'></td>
                          </tr>";
                }
                ?>
                <tr>
                    <td>
                        Kích cỡ khác: <input type="number" name="other_size" placeholder="Nhập kích cỡ" min="0">
                    </td>
                    <td>
                        <input type="number" name="quantity_other" placeholder="Số lượng" min="0" value="0">
                    </td>
                </tr>
            </table>
            <button type="submit">Thêm Chi Tiết Giày</button>
        </form>
    </div>
</body>
</html>
