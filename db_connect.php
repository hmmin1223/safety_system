<?php
$server = "localhost";
$username = "safetymanager";
$password = "ecc";
$database = "dbsaigai";


$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("アクセスできません：" . $conn->connect_error);
}

?>
