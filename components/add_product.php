<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/add_product.css" />
    <title>Add Product</title>
</head>
<body>
    <div id="add_product_box">
        <img src="/VUONGTINHSNEAKER/IMAGES/logo.png" alt="logo" width="125">
        <h3>Add a New Product</h3>
        <p>Fill in the details of the new product you want to add to the store.</p>
        
        <div class="form">
            <form method="POST" action="add_product.php" enctype="multipart/form-data">
                <input type="text" name="st_name" placeholder="Product Name" required>
                <input type="file" name="st_image" required>
                <div class="gender">
                    <label><input type="radio" name="st_gen" value="male" required> Male</label>
                    <label><input type="radio" name="st_gen" value="female" required> Female</label>
                </div>
                <input type="number" name="st_price" placeholder="Price" required>
                <button type="submit" id="add_product_btn">Add Product</button>
            </form>
        </div>
    </div>

    <?php
    // Include the database connection
    include "connect-db.php";

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get data from the form
        $st_name = $_POST['st_name'] ?? '';
        $st_gen = $_POST['st_gen'] ?? '';
        $st_price = $_POST['st_price'] ?? '';

        // Handle the image upload
        if (isset($_FILES['st_image']) && $_FILES['st_image']['error'] == 0) {
            $image_tmp = $_FILES['st_image']['tmp_name'];
            $image_name = $_FILES['st_image']['name'];
            $image_size = $_FILES['st_image']['size'];
            $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

            // Define allowed image extensions
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array(strtolower($image_ext), $allowed_extensions)) {
                // Check if the image size is not too large (e.g., 5MB max)
                if ($image_size <= 5 * 1024 * 1024) {
                    $image_path = "/VUONGTINHSNEAKER/IMAGES/" . uniqid() . "." . $image_ext;
                    
                    // Move the uploaded image to the images folder
                    if (move_uploaded_file($image_tmp, $_SERVER['DOCUMENT_ROOT'] . $image_path)) {
                        // Check if the product already exists in the database
                        $stmt_check = $db_server->prepare("SELECT * FROM shoe_type WHERE st_name = ?");
                        $stmt_check->bind_param("s", $st_name);
                        $stmt_check->execute();
                        $result = $stmt_check->get_result();

                        if ($result->num_rows > 0) {
                            echo '<script>alert("Product already exists!");</script>';
                            $stmt_check->close();
                        } else {
                            $stmt_check->close();
                            $stmt = $db_server->prepare("INSERT INTO shoe_type (st_name, st_image_link, st_gen, st_price) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("sssi", $st_name, $image_path, $st_gen, $st_price);

                            if ($stmt->execute()) {
                                echo "<script>alert('Product added successfully!'); window.location.href='add_shoe.php';</script>";
                            } else {
                                echo "<script>alert('Failed to add product. Please try again.');</script>";
                            }
                            $stmt->close();
                        }
                    } else {
                        echo "<script>alert('Failed to upload image. Please try again.');</script>";
                    }
                } else {
                    echo "<script>alert('Image size is too large. Maximum allowed size is 5MB.');</script>";
                }
            } else {
                echo "<script>alert('Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
            }
        } else {
            echo "<script>alert('Please select an image to upload.');</script>";
        }
    }
    ?>
</body>
</html>
