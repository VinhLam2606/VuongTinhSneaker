<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/VUONGTINHSNEAKER/styles/signup.css">
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
                <form>
                    <input type="tel" id = "phonenumber" placeholder="Phone number" autofocus  required minlength="10">
                    <input type="email" id = "email" placeholder="Email address" autofocus  required minlength="5">
                    <input type="password" id = "password" placeholder="Password" required minlength="3">
                    <input type="text" id = "first" placeholder="First Name" required minlength="1">
                    <input type="text" id = "last" placeholder="Last Name" required minlength="1">
                    <input type="text" id = "birth" placeholder="Date of Birth" onfocus="(this.type='date')" required>
                    <input type="text" id="address" placeholder="Address">
                    <div class="gender">
                        <label>
                            <input type="radio" name="gender" value="male"> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female"> Female
                        </label>
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
                    <button type="submit" id = "sign_up">SIGN UP</button>

                </form>
        </div>

        <script src="../scripts/signup.js"> </script>

        <?php
                require "/VUONGTINHSNEAKER/components/connect-db.php";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Nhận dữ liệu từ form
                    $phonenumber = $_POST['phonenumber'] ?? "";
                    $email = $_POST['email'] ?? "";
                    $password = $_POST['password'] ?? "";
                    $firstname = $_POST['firstname'] ?? "";
                    $lastname = $_POST['lastname'] ?? "";
                    $birth = $_POST['birth'] ?? "";
                    $address = $_POST['address'] ?? "";
                    $gender = $_POST['gender'] ?? "";

                    // Kiểm tra dữ liệu không rỗng
                    if (!$phonenumber || !$email || !$password || !$firstname || !$lastname || !$birth || !$address || !$gender) {
                        die("All fields are required!");
                    }

                    // Mã hóa mật khẩu
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Chèn dữ liệu vào bảng accounts
                    $stmt1 = $db_server->prepare("INSERT INTO accounts (account_email, account_passwd) VALUES (?, ?)");
                    $stmt1->bind_param("ss", $email, $hashed_password);
                    
                    if (!$stmt1->execute()) {
                        die("Error inserting into accounts: " . $stmt1->error);
                    }
                    $stmt1->close();

                    // Chèn dữ liệu vào bảng customers
                    $stmt2 = $db_server->prepare("INSERT INTO customers (customer_phone_number, customer_email, customer_first_name, customer_last_name, customer_dob, customer_address, customer_gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt2->bind_param("sssssss", $phonenumber, $email, $firstname, $lastname, $birth, $address, $gender);
                    
                    if (!$stmt2->execute()) {
                        die("Error inserting into customers: " . $stmt2->error);
                    }
                    $stmt2->close();

                    echo "Sign up successful!";
                }
                ?>

    </body>
</html>