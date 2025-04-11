<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "VuongTinhSneaker";

$db_server = new mysqli($hostname, $username, $password, $database);

if ($db_server->connect_error) {
    die("Couldn't connect to MySQL: " . $db_server->connect_error);
}

$db_server->set_charset('utf8');

?>
