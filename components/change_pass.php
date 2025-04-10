<?php
session_start();

include "connect-db.php";

$user_id = $_SESSION["user_id"];

$stmt = $db_server->prepare("SELECT account_passwd FROM accounts WHERE account_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stored_password = $row['account_passwd'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($current_password === $stored_password) {
        if ($new_password === $confirm_password) {
            $stmt1 = $db_server->prepare("UPDATE accounts SET account_passwd = ? WHERE account_id = ?");
            $stmt1->bind_param("ss", $new_password, $user_id);
            $stmt1->execute();
            echo "<script>alert('Đổi mật khẩu thành công!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Mật khẩu trùng khớp!')</script>";
        }
    } else {
        echo "<script>alert('Mật khẩu không chính xác!')</script>";
    }
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
        <img src="/VUONGTINHSNEAKER/IMAGES/logo.png" alt="logo" class="logo" width="80">
        <img src="<?php echo $_SESSION['avatar']; ?>" alt="User Avatar" class="avatar" width="60">
        <h3>Change Your Password</h3>
        <form method="POST">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <button id="change_inf" type="submit">Confirm</button>
        </form>
        <br>
        <a href="information.php">Back to Profile</a>
    </div>
</body>

</html>