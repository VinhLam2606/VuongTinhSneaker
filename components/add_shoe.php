<?php
session_start();
include "connect-db.php";

<<<<<<< HEAD
=======
// If there's no st_id in the session, get the latest product from the shoe_type table
>>>>>>> bdd1fdc1b76d3f0cbf517e2801cecdd6d3d2f069
if (!isset($_SESSION['st_id'])) {
    $result = $db_server->query("SELECT st_id FROM shoe_type ORDER BY st_id DESC LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['st_id'] = $row['st_id'];
    } else {
<<<<<<< HEAD
        die("Can't find any products. Please add some products first.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $st_id = $_SESSION['st_id'];

=======
        die("No product found. Please add a product first.");
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $st_id = $_SESSION['st_id'];

    // Fixed sizes from 37 to 43
>>>>>>> bdd1fdc1b76d3f0cbf517e2801cecdd6d3d2f069
    foreach (range(37, 43) as $size) {
        $quantity = isset($_POST['quantity_' . $size]) ? (int)$_POST['quantity_' . $size] : 0;
        for ($i = 0; $i < $quantity; $i++) {
            $stmt = $db_server->prepare("INSERT INTO shoe (st_id, shoe_size) VALUES (?, ?)");
            $stmt->bind_param("ii", $st_id, $size);
            $stmt->execute();
            $stmt->close();
        }
    }

<<<<<<< HEAD
=======
    // Handle other sizes
>>>>>>> bdd1fdc1b76d3f0cbf517e2801cecdd6d3d2f069
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

<<<<<<< HEAD
    echo "<script>alert('Add shoe successfully!'); window.location.href='admin_page.php';</script>";
=======
    echo "<script>alert('Shoes added successfully!'); window.location.href='admin_page.php';</script>";
>>>>>>> bdd1fdc1b76d3f0cbf517e2801cecdd6d3d2f069
}
?>

<!DOCTYPE html>
<<<<<<< HEAD
<html lang="vi">

=======
<html lang="en">
>>>>>>> bdd1fdc1b76d3f0cbf517e2801cecdd6d3d2f069
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vuong Tinh Sneaker</title>
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/add_shoe.css">
</head>

<body>
    <div id="add_shoe_box">
<<<<<<< HEAD
        <h3>Add Details For New Products</h3>
        <p>Enter the quantity of shoes for each available size from 37 to 43, and for other sizes if applicable.</p>
=======
        <h3>Add Shoe Details for the New Product</h3>
        <p>Enter the quantity of shoes for available sizes from 37 to 43 and any other sizes if applicable.</p>
>>>>>>> bdd1fdc1b76d3f0cbf517e2801cecdd6d3d2f069
        <form method="POST" action="add_shoe.php">
            <table>
                <tr>
                    <th>Size</th>
                    <th>Quantity</th>
                </tr>
                <?php
<<<<<<< HEAD
=======
                // Display rows for sizes 37 to 43
>>>>>>> bdd1fdc1b76d3f0cbf517e2801cecdd6d3d2f069
                foreach (range(37, 43) as $size) {
                    echo "<tr>
                            <td>$size</td>
                            <td><input type='number' name='quantity_$size' min='0' value='0'></td>
                          </tr>";
                }
                ?>
                <tr>
                    <td>
<<<<<<< HEAD
                        Others: <input id="another_size" type="number" name="other_size" placeholder="Enter size" min="0">
=======
                        Other: <input id="another_size" type="number" name="other_size" placeholder="Enter size" min="0">
>>>>>>> bdd1fdc1b76d3f0cbf517e2801cecdd6d3d2f069
                    </td>
                    <td>
                        <input type="number" name="quantity_other" placeholder="Quantity" min="0" value="0">
                    </td>
                </tr>
            </table>
<<<<<<< HEAD
            <button type="submit">Add Shoe's Details</button>
=======
            <button type="submit">Add Shoe Details</button>
>>>>>>> bdd1fdc1b76d3f0cbf517e2801cecdd6d3d2f069
        </form>
    </div>
</body>

</html>