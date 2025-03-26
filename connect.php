<?php
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db   = "mhs"; 

$con = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>