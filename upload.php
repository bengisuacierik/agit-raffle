<?php
error_reporting(0); 
ini_set('display_errors', 0);


include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $dosyaAdi = $_FILES["file"]["tmp_name"];

    if ($_FILES["file"]["size"] > 0) {
        $txtDosya = fopen($dosyaAdi, "r");
        $csvDosyaAdi = "katilimcilar.csv";
        $csvDosya = fopen($csvDosyaAdi, "w");

        
        fputcsv($csvDosya, ["isim", "email"], ",", '"', "\\");

        while (($satir = fgets($txtDosya)) !== false) {
            $satir = trim($satir);
            $veriler = explode(",", $satir);

            if (count($veriler) == 2) { 
                fputcsv($csvDosya, $veriler, ",", '"', "\\");
            }
        }

        fclose($txtDosya);
        fclose($csvDosya);

        
        $conn->query("TRUNCATE TABLE katilimcilar");

      
        $csvDosya = fopen($csvDosyaAdi, "r");

        // İlk satırı (başlıkları) atla
        fgetcsv($csvDosya, 1000, ",", '"', "\\");

        while (($satir = fgetcsv($csvDosya, 1000, ",", '"', "\\")) !== FALSE) {
            $isim = $satir[0];
            $email = $satir[1];

            // Veritabanına ekle
            $sql = "INSERT INTO katilimcilar (isim, email) VALUES ('$isim', '$email')";
            $conn->query($sql);
        }

        fclose($csvDosya);

        
        chmod($csvDosyaAdi, 0777);
        
        
        if (file_exists($csvDosyaAdi)) {
            unlink($csvDosyaAdi);
        }

    }
} else {
    echo "<h3>Dosya yükleme hatası oluştu.</h3>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dosya Yükleme Başarılı</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="overlay"></div> 
    <h1>Dosyanız başarıyla yüklendi!</h1>
    <h3>Şimdi çekilişi başlatabilirsiniz.</h3>
    <a href="index.php">Ana Sayfaya Dön</a> |
    <a href="draw.php">Çekilişi Başlat</a>
</body>
</html>


