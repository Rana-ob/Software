<?php
require_once "phpqrcode/qrlib.php";

$from = $_POST['from'] ?? 'غير محدد';
$to = $_POST['to'] ?? 'غير محدد';
$type = $_POST['type'] ?? 'غير محدد';
$payment = $_POST['payment_method'] ?? 'غير محددة';

// QR + تأكيد
$confirmation = strtoupper(substr(md5(uniqid()), 0, 8));
$qrText = "من: $from\nإلى: $to\nنوع: $type\nالدفع: $payment\nرقم التأكيد: $confirmation";
$tempDir = "qr_temp/";
if (!file_exists($tempDir)) mkdir($tempDir);
$filename = $tempDir . uniqid("qr_") . ".png";
QRcode::png($qrText, $filename, QR_ECLEVEL_H, 5);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد الحجز</title>
    <link rel="stylesheet" href="s2.css">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0b0616;
            font-family: 'Almarai', sans-serif;
        }
        .confirmation-box {
            text-align: center;
            margin: 100px auto;
            background-color: #1e1b29;
            padding: 40px;
            border-radius: 20px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(162, 89, 255, 0.3);
            color: white;
        }
        .confirmation-box h2 {
            color: #A259FF;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .confirmation-box p {
            font-size: 18px;
            margin: 10px 0;
        }
        .confirmation-box img {
            margin: 20px 0;
            border: 3px solid #A259FF;
            border-radius: 12px;
        }
        .confirmation-code {
            font-size: 20px;
            font-weight: bold;
            color:#A259FF ;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header class="header">
    <a href="homepage.html" class="logo">
        <img src="logo1.png" alt="Logo" width="100" height="100"> 
    </a>
    <nav class="nav-links">
        <a href="match_1.html">مباريات</a>
        <a href="Entertimante.html">ترفية ومناطق التشجيع</a>
        <a href="tranrport2.html">المواصلات</a>
        <a href ="#" id="language-link">
            <img src="Language.png" alt="Language" id="language-icon">
        </a>        
    </nav>
</header>

<div class="confirmation-box">
    <h2>🎉 تم الحجز بنجاح</h2>
    <p>من: <?= htmlspecialchars($from) ?></p>
    <p>إلى: <?= htmlspecialchars($to) ?></p>
    <p>نوع الوسيلة: <?= htmlspecialchars($type) ?></p>
    <img src="<?= $filename ?>" alt="رمز الاستجابة السريعة" width="200">
    <p class="confirmation-code">رقم التأكيد: <?= $confirmation ?></p>
    <p>طريقة الدفع: <?= htmlspecialchars($payment) ?></p>

</div>

<footer class="footer">
    <div class="footer-section footer-logo">
        <img src="logo1.png" alt="Hayyakm 2034">
    </div>
    <div class="footer-section">Contact</div>
    <div class="footer-section">Hayyakm2034@gmail.com</div>
    <div class="footer-section">Services</div>
    <div class="footer-section social-icon">
        <img src="WhatsApp.png" alt="WhatsApp" class="social-link">
        <img src="Tiktok.png" alt="Tiktok" class="social-link">
        <img src="x.png" alt="Snapchat" class="social-link">
        <img src="facebook.png" alt="Instagram" class="social-link">
    </div>
    <div class="footer-section">©Hayyakm2034</div>
</footer>

</body>
</html>