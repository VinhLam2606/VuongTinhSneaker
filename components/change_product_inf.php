<?php
include 'connect-db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st_id = isset($_POST['st_id']) ? intval($_POST['st_id']) : 0;
    $st_name = isset($_POST['st_name']) ? trim($_POST['st_name']) : '';
    $st_price = isset($_POST['st_price']) ? floatval($_POST['st_price']) : 0;
    $st_gen = isset($_POST['st_gen']) ? trim($_POST['st_gen']) : '';
    $st_image_link = isset($_POST['st_image_link']) ? trim($_POST['st_image_link']) : '';

    if ($st_id <= 0 || empty($st_name) || $st_price <= 0 || empty($st_gen)) {
        echo json_encode([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.'
        ]);
        exit;
    }

    $query = "UPDATE shoe_type 
              SET st_name = ?, st_price = ?, st_gen = ?, st_image_link = ? 
              WHERE st_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi kết nối cơ sở dữ liệu: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param("sdssi", $st_name, $st_price, $st_gen, $st_image_link, $st_id);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật thông tin sản phẩm thành công.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Cập nhật thông tin sản phẩm thất bại.'
        ]);
    }
    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Yêu cầu không hợp lệ.'
    ]);
}
?>
