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
        echo "<pre>";
        echo "Phone Number: $phonenumber\n";
        echo "Email: $email\n";
        echo "Password: $password\n";
        echo "First Name: $firstname\n";
        echo "Last Name: $lastname\n";
        echo "Date of Birth: $birth\n";
        echo "Address: $address\n";
        echo "Gender: $gender\n";
        echo "</pre>";
    } else {
        echo "fail";
    }
?>