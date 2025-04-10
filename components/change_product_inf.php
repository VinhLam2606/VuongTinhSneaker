<?php
session_start();
include "connect-db.php";

if (isset($_GET['st_id'])) {
    $st_id = $_GET['st_id'];

    $stmt = $db_server->prepare("SELECT * FROM shoe_type WHERE st_id = ?");
    $stmt->bind_param("i", $st_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Product not found.";
        exit;
    }

    $shoe = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "No product ID provided.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st_name = $_POST['st_name'] ?? '';
    $st_gen = $_POST['st_gen'] ?? '';
    $st_price = $_POST['st_price'] ?? '';

    $st_image_link = $shoe['st_image_link'];

    if (isset($_FILES['st_image_link']) && $_FILES['st_image_link']['error'] == 0) {

        $upload_dir = '/VUONGTINHSNEAKER/IMAGES/';
        $tmp_name = $_FILES['st_image_link']['tmp_name'];
        $image_name = basename($_FILES['st_image_link']['name']);
        $image_path = $upload_dir . $image_name;


        if (move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'] . $image_path)) {
            $st_image_link = $image_path;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }


    $stmt = $db_server->prepare("UPDATE shoe_type SET st_name=?, st_image_link=?, st_gen=?, st_price=? WHERE st_id=?");
    $stmt->bind_param("sssii", $st_name, $st_image_link, $st_gen, $st_price, $st_id);

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href='admin_page.php';</script>";
    } else {
        echo "<script>alert('Failed to update product, please try again.');</script>";
    }
    $stmt->close();
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Vuong Tinh Sneaker</title>
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/change_inf.css">
</head>

<body>
    <div id="change_inf_box">
        <img src="<?php echo htmlspecialchars($shoe['st_image_link']); ?>" alt="shoe" width="150">
        <h3>Change Product Information</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="st_name" placeholder="Product Name" value="<?php echo htmlspecialchars($shoe['st_name']); ?>" required>
            <input type="file" name="st_image_link" accept="image/*">
            <input type="text" name="st_gen" placeholder="Gender" value="<?php echo htmlspecialchars($shoe['st_gen']); ?>" required>
            <input type="number" name="st_price" placeholder="Price" value="<?php echo htmlspecialchars($shoe['st_price']); ?>" required>
            <button id="change_inf" type="submit">Save Changes</button>
        </form>
        <div class="back-btn">
            <a href="show_shoe_inf.php?st_id=<?php echo urlencode($st_id); ?>">←</a>
        </div>
    </div>
</body>

</html>