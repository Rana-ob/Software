<?php
session_start();

$_SESSION['from'] = $_POST['from'] ?? '';
$_SESSION['to'] = $_POST['to'] ?? '';
$_SESSION['type'] = $_POST['type'] ?? '';
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الدفع</title>
    <link rel="stylesheet" href="s2.css">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #0a0213;
            color: white;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .payment-box {
            background-color: #1e1b29;
            padding: 50px 30px;
            margin: 100px auto;
            border-radius: 20px;
            max-width: 450px;
            box-shadow: 0 0 20px rgba(162, 89, 255, 0.3);
            border: 2px solid #a855f7;
        }

        .payment-box h2 {
            color: #a855f7;
            margin-bottom: 20px;
            font-size: 26px;
        }

        .payment-box p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .pay-options {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 25px;
            text-align: right;
        }

        .pay-option {
            background-color: #2a223a;
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .pay-option input {
            accent-color: #a855f7;
            width: 20px;
            height: 20px;
        }

        .pay-option:hover {
            border-color: #7d3bb8;
            background-color: #3a2f50;
        }

        .pay-option img {
            width: 35px;
            height: 35px;
            object-fit: contain;
        }

        .pay-btn {
            background: linear-gradient(135deg, #a855f7, #9333ea);
            color: white;
            padding: 14px 38px;
            font-size: 18px;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            font-family: 'Almarai', sans-serif;
            font-weight: bold;
            box-shadow: 0 6px 20px rgba(168, 85, 247, 0.4);
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }

        .pay-btn:hover {
            background: linear-gradient(135deg, #9333ea, #a855f7);
            transform: scale(1.07);
            box-shadow: 0 10px 25px rgba(168, 85, 247, 0.6);
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #a855f7;
            text-decoration: none;
            font-size: 15px;
        }

        .back-link:hover {
            text-decoration: underline;
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

<div class="payment-box">
    <h2>💳 الدفع</h2>
    <p>اختر وسيلة الدفع المفضلة لديك</p>

<form action="confirm_booking.php" method="POST">
    <input type="hidden" name="from" value="<?= htmlspecialchars($_POST['from']) ?>">
    <input type="hidden" name="to" value="<?= htmlspecialchars($_POST['to']) ?>">
    <input type="hidden" name="type" value="<?= htmlspecialchars($_POST['type']) ?>">

    <div class="pay-options">
        <!-- خيارات الدفع -->
        <label class="pay-option">
            <input type="radio" name="payment_method" value="بطاقة ائتمانية" checked>
            <img src="card.png" alt="بطاقة"> بطاقة ائتمانية
        </label>
        <label class="pay-option">
            <input type="radio" name="payment_method" value="Apple Pay">
            <img src="apple.jpg" alt="Apple Pay"> Apple Pay
        </label>
        <label class="pay-option">
            <input type="radio" name="payment_method" value="STC Pay">
            <img src="stc.jpg" alt="STC Pay"> STC Pay
        </label>
    </div>

    <button type="submit" class="pay-btn">ادفع الآن</button>
</form>


    <a class="back-link" href="javascript:history.back()">🔙 الرجوع</a>
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
