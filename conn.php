<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // default XAMPP password is empty
$db   = 'mumbaitourism'; // use your DB name here

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
