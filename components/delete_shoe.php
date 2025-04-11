<?php
include 'connect-db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $shoe_id = intval($_POST['id']);

    if (!$db_server) {
        echo json_encode(["success" => false, "message" => "Database connection failed."]);
        exit;
    }

    $db_server->begin_transaction();

    try {
        $deleteShoe = $db_server->prepare("DELETE FROM shoe WHERE st_id = ?");
        $deleteShoe->bind_param("i", $shoe_id);
        $deleteShoe->execute();
        $deleteShoe->close();


        $deleteShoeType = $db_server->prepare("DELETE FROM shoe_type WHERE st_id = ?");
        $deleteShoeType->bind_param("i", $shoe_id);
        $deleteShoeType->execute();
        $deleteShoeType->close();

        $db_server->commit();

        echo json_encode(["success" => true, "message" => "Product deleted successfully."]);
    } catch (Exception $e) {
        $db_server->rollback();
        echo json_encode(["success" => false, "message" => "Failed to delete product. Error: " . $e->getMessage()]);
    }
}
?>
