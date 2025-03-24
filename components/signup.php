<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/VUONGTINHSNEAKER/style/signup.css">
    </head>
    <body>
        <div id="signup_box">
            <img src="/VUONGTINHSNEAKER/IMAGES/logo.png" alt="logo" width="125">
            <h3>BECOME A VUONG TINH MEMBER</h3>
            <p>Create your Nike Member profile and get first
                    access to the very best of Nike products, inspiration
                    and community.
            </p>
            <div class="form">
                <form method="POST" action="signup.php">
                    <input type="tel" name="phonenumber" placeholder="Phone number" required minlength="10">
                    <input type="email" name="email" placeholder="Email address" required minlength="5">
                    <input type="password" name="password" placeholder="Password" required minlength="3">
                    <input type="text" name="firstname" placeholder="First Name" required>
                    <input type="text" name="lastname" placeholder="Last Name" required>
                    <input type="date" name="birth" required>
                    <input type="text" name="address" placeholder="Address">
                    <div class="gender">
                        <label><input type="radio" name="gender" value="male"> Male</label>
                        <label><input type="radio" name="gender" value="female"> Female</label>
                    </div>
                    <div id = "tick_box">
                        <div>
                            <input type="checkbox" name="" id="">
                            <p>Sign up fo emails to get updates from Vuong Tinh on
                                products,offer and your Member benefits
                            </p>
                        </div>
                        <p>By Creating an account, you agree to Vuong Tinh's <a href="https://agreementservice.svs.nike.com/rest/agreement?agreementType=privacyPolicy&country=IN&language=en&mobileStatus=false&requestType=redirect&uxId=com.nike.commerce.nikedotcom.web">Privacy Policy</a>
                            and 
                            <a href="https://agreementservice.svs.nike.com/rest/agreement?agreementType=termsOfUse&country=IN&language=en&mobileStatus=true&requestType=redirect&uxId=com.nike.commerce.nikedotcom.web">Terms of Use.</a></p>
                    </div>
                    <button id="sign_up" type="submit">SIGN UP</button>
                </form>
            </div>
        </div>

        <?php
            include "connect-db.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $phonenumber = $_POST['phonenumber'] ?? "";
                $email = $_POST['email'] ?? "";
                $password = $_POST['password'] ?? "";
                $firstname = $_POST['firstname'] ?? "";
                $lastname = $_POST['lastname'] ?? "";
                $birth = $_POST['birth'] ?? "";
                $address = $_POST['address'] ?? "";
                $gender = $_POST['gender'] ?? "";

                // Kiểm tra email đã tồn tại chưa
                $stmt_check = $db_server->prepare("SELECT * FROM accounts WHERE account_email = ?");
                $stmt_check->bind_param("s", $email);
                $stmt_check->execute();
                $result = $stmt_check->get_result();
                if ($result->num_rows > 0) {
                    die("Email already exists!");
                }
                $stmt_check->close();

                // Chèn dữ liệu vào bảng accounts
                $stmt1 = $db_server->prepare("INSERT INTO accounts (account_email, account_passwd) VALUES (?, ?)");
                $stmt1->bind_param("ss", $email, $password);
                $stmt1->execute();
                $stmt1->close();

                // Lấy account_id vừa tạo
                $account_id = $db_server->insert_id;

                // Chèn dữ liệu vào bảng customers
                $stmt2 = $db_server->prepare("INSERT INTO customers (account_id, customer_phone_number, customer_first_name, customer_last_name, customer_dob, customer_address, customer_gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt2->bind_param("issssss", $account_id, $phonenumber, $firstname, $lastname, $birth, $address, $gender);
                $stmt2->execute();
                $stmt2->close();

                echo "<script>alert('Sign up successful!'); window.location.href='login.php';</script>";
            }
        ?>
    </body>
</html>
