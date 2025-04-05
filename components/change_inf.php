<?php
session_start();
include "connect-db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phonenumber = $_POST['phonenumber'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $birth = $_POST['birth'] ?? '';
    $address = $_POST['address'] ?? '';
    $gender = $_POST['gender'] ?? '';
    
    $user_id = $_SESSION['user_id'];
    
    $stmt = $db_server->prepare("UPDATE customers SET customer_first_name=?, customer_last_name=?, customer_dob=?, customer_address=?, customer_gender=?, customer_phone_number=? WHERE account_id=?");
    $stmt->bind_param("ssssssi", $firstname, $lastname, $birth, $address, $gender, $phonenumber, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['username'] = $firstname;
        $_SESSION['userlastname'] = $lastname;
        $_SESSION['user_dob'] = $birth;
        $_SESSION['user_address'] = $address;
        $_SESSION['user_gender'] = $gender;
        $_SESSION['user_phone_number'] = $phonenumber;
        echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='information.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!');</script>";
    }
    $stmt->close();
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Change Information</title>
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/change_inf.css">
</head>
<body>
    <div id="change_inf_box">
        <img src="/VUONGTINHSNEAKER/IMAGES/logo.png" alt="logo" class="logo" width="125">
        <img src="<?php echo $_SESSION['avatar'] ?>" alt="User Avatar" class="avatar">
        <h3>Change Your Information</h3>
        <form method="POST">
            <input type="text" name="firstname" placeholder="First Name" value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>" required>
            <input type="text" name="lastname" placeholder="Last Name" value="<?php echo htmlspecialchars($_SESSION['userlastname'] ?? ''); ?>" required>
            <input type="date" name="birth" value="<?php echo htmlspecialchars($_SESSION['user_dob'] ?? ''); ?>" required>
            <input type="text" name="phonenumber" placeholder="Phone Number" value="<?php echo htmlspecialchars($_SESSION['user_phone_number'] ?? ''); ?>">
            <input type="text" name="address" placeholder="Address" value="<?php echo htmlspecialchars($_SESSION['user_address'] ?? ''); ?>">
            <div class="gender">
                    <label>
                        <input type="radio" name="gender" value="male" <?php echo ($_SESSION['user_gender'] ?? '') === 'male' ? 'checked' : ''; ?>> Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female" <?php echo ($_SESSION['user_gender'] ?? '') === 'female' ? 'checked' : ''; ?>> Female
                    </label>
            </div>
            <button id="change_inf" type="submit">Save Changes</button>
        </form>
        <br>
        <a href="information.php">Back to Profile</a>
    </div>
</body>
</html>
