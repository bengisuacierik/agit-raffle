<?php
$servername = "localhost";
$username = "root";
$password = "";  // Eğer şifren varsa buraya yaz
$dbname = "cekilis_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}
?>
