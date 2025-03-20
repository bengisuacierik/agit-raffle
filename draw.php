<?php
include 'db.php';

// Katılımcı var mı kontrol et
$sql = "SELECT * FROM katilimcilar";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<h3>Önce bir katılımcı listesi yüklemelisiniz!</h3>";
    echo "<a href='index.php'>Dosya Yükle</a>";
    exit();
}

// Rastgele bir kazanan seç
$sql = "SELECT * FROM katilimcilar ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Çekiliş Sonucu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="overlay"></div> <!-- Opak katman -->
    <h1>Çekiliş Sonucu</h1>

    <?php if ($result->num_rows > 0): 
        $kazanan = $result->fetch_assoc();
    ?>
        <div class="kazanan-box">
            <h2>Kazanan: <?php echo $kazanan['isim']; ?> (<?php echo $kazanan['email']; ?>)</h2>
        </div>
    <?php endif; ?>

    <h3>Yeni bir çekiliş yapmak için tekrar dosya yükleyin.</h3>
    <a href="index.php">Dosya Yükle</a>

    <?php
    // ✅ **Çekiliş yapıldıktan sonra tüm verileri temizle**
    $conn->query("TRUNCATE TABLE katilimcilar");
    ?>
</body>
</html>



