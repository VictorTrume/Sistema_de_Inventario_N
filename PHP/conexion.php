<?php
$host = 'localhost';
$user = 'u429910053_2112';
$password = 'UWCEtEAX?7*#!9p23!iopKt';
$db = 'u429910053_almancenpro';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>