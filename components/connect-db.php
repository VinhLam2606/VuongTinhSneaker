<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "VuongTinhSneaker";

// Kết nối MySQLi
$db_server = new mysqli($hostname, $username, $password, $database);

// Kiểm tra kết nối
if ($db_server->connect_error) {
    die("Couldn't connect to MySQL: " . $db_server->connect_error);
}

// Đặt bộ ký tự thành UTF-8
$db_server->set_charset('utf8');

?>
