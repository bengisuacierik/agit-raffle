<?php
include 'db.php';

// CSV dosyasını aç
$dosya = fopen("katilimcilar.csv", "r");

if ($dosya === false) {
    die("CSV dosyası açılamadı.");
}

// İlk satırı (başlıkları) atla
fgetcsv($dosya);

while (($satir = fgetcsv($dosya, 1000, ",")) !== FALSE) {
    $isim = $satir[0];
    $email = $satir[1];

    // Veritabanına ekle
    $sql = "INSERT IGNORE INTO katilimcilar (isim, email) VALUES ('$isim', '$email')";
    $conn->query($sql);
}

fclose($dosya);

echo "CSV dosyasından katılımcılar başarıyla yüklendi!";
?>
