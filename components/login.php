<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/login.css">
</head>

<body>
    <div id="login_box">

        <img src="../images/logo.png" alt="logo" width="125">
        <h3>YOUR ACCOUNT FOR EVERYTHING VUONG TINH SNEAKER </h3>
        <form id="login_form" method="POST">
            <input type="email" name="email" id="email" placeholder="Email address" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button id="sign_in" type="submit">SIGN IN</button>
        </form>
        <p>Not a Member?<a href="signup.php">Sign up member</a></p>
        <br>
    </div>
    <?php
        include "connect-db.php";

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"] ?? "";
            $password = $_POST["password"] ?? "";
            
            if (empty($email) || empty($password)) {
                echo "<script>alert('Vui lòng nhập đầy đủ email và mật khẩu!');</script>";
            } else {
                $stmt = $db_server->prepare("SELECT * FROM accounts WHERE account_email = ?");
                $stmt->bind_param("s",$email);
                $stmt->execute();
                $result = $stmt->get_result();
            
                if ($row = $result->fetch_assoc()) {
                    if ($password === $row["account_passwd"]) {
                        echo "<script>alert('Đăng nhập thành công!'); window.location.href='/VUONGTINHSNEAKER/main.php';</script>";
                    } else {
                        echo "<script>alert('Mật khẩu không chính xác!');</script>";    
                    }
                } else {
                    echo "<script>alert('Email không tồn tại!');</script>";
                }
            }
            $stmt->close();
        }

    ?>
</body>

</html>