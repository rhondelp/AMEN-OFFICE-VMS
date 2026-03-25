<?php
date_default_timezone_set('Asia/Manila');
$conn = new mysqli("localhost", "root", "", "amen_vms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->query("SET time_zone = '+08:00'");
?>