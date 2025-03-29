
<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // أول شيء تفعيل السيشن

$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التأكد من تسجيل الدخول
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    // إذا مو مسجل دخول نوجهه لصفحة تسجيل الدخول
    header('Location: logIn.php');
    exit();
}

// بيانات المستخدم
$userQuery = "SELECT * FROM customer WHERE CUSTOMER_ID = $userId";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();

// بيانات الحجوزات
$bookingQuery = "SELECT r.*, m.TEAM1_AR, m.TEAM2_AR, m.MATCH_DATE, m.VENUE 
                 FROM reservation_ticket r 
                 JOIN matches m ON r.MATCH_ID = m.MATCH_ID 
                 WHERE r.CUSTOMER_ID = $userId";
$bookingResult = $conn->query($bookingQuery);

// بيانات المفضلات
$favQuery = "SELECT M.* FROM matches M JOIN favorites F ON M.MATCH_ID = F.MATCH_ID WHERE F.USER_ID = $userId";
$favResult = $conn->query($favQuery);
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>transport</title>
    <link rel="stylesheet" href="s1.css">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <a href="homepage.html" class="logo">
            <img src="Images/logo1.png" alt="Logo" width="100" height="100"> 
        </a>
        <nav class="nav-links">
           <a href="personalfile.php">الملف الشخصي </a>

            <a href="match_1.html">مباريات</a>
            <a href="Entertimante.html">ترفيه ومناطق التشجيع</a>
            <a href="tranrport2.html">المواصلات</a>
            <a href ="#" id="language-link">
            <img src="Images/Language.png" alt="Language" id="language-icon"></a>        
        </nav>
    </header>

    <div class="container">
        <section class="profile">
            <br>
            <h2>الملف الشخصي</h2>
            <label>الاسم كامل</label>
            <input type="text" value="<?= $user['CUSTOMER_NAME'] ?>" readonly>
            <label>البريد الإلكتروني</label>
            <input type="email" value="<?= $user['CUSTOMER_EMAIL'] ?>" readonly>
            <label>رقم الهاتف (اختياري)</label>
            <input type="text" value="<?= $user['CUSTOMER_Phone'] ?>" readonly>
        </section>

        <section class="bookings">
            <br>
            <h2>الحجوزات</h2>
            <?php while($booking = $bookingResult->fetch_assoc()) { ?>
            <div class="booking-card">
                <p><strong><?= $booking['TEAM1_AR'] ?> × <?= $booking['TEAM2_AR'] ?></strong></p>
                <p><?= $booking['MATCH_DATE'] ?> | <?= $booking['TIME'] ?></p>
                <p>ملعب: <?= $booking['VENUE'] ?></p>
                <div class="actions">
                    <a href="edit_booking.php?id=<?= $booking['RESERVATION_ID'] ?>" class="edit">تعديل ✏️</a>
                    <a href="delete_booking.php?id=<?= $booking['RESERVATION_ID'] ?>" class="delete">حذف ❌</a>
                </div>
            </div>
            <?php } ?>
        </section>
        <br>

        <section class="resale">
            <div class="resale-card">
                <h3>اعد بيع تذكرتك</h3>
                <p>لم تعد بحاجة للتذكرة؟ أو حصل لك امر طارئ ولن تستطيع الحضور؟</p>
                <p>اعد بيع تذكرتك بكل سهولة على منصة إعادة البيع</p>
                <a href="Resale.html" class="resale-btn">اذهب إلى إعادة البيع</a>
            </div>
        </section>

        <section class="favorites">
            <br>
            <h2>المفضلات</h2>
            <div id="favorites-list">
                <?php while($row = $favResult->fetch_assoc()) { ?>
                <div class="booking-card">
                    <p><strong><?= $row['TEAM1_AR'] ?> × <?= $row['TEAM2_AR'] ?></strong></p>
                    <p><?= $row['MATCH_DATE'] ?></p>
                    <p>الملعب: <?= $row['VENUE'] ?></p>
                    <div class="actions">
                        <form method="POST" action="remove_favorite.php">
                            <input type="hidden" name="match_id" value="<?= $row['MATCH_ID'] ?>">
                            <button type="submit" class="delete">حذف ❌</button>
                        </form>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
    </div>

    <br>
    <footer class="footer">
        <div class="footer-section footer-logo">
            <img src="Images/logo1.png" alt="Hayyakm 2034">
        </div>
        <div class="footer-section">Contact</div>
        <div class="footer-section">Hayyakm2034@gmail.com</div>
        <div class="footer-section">Services</div>
        <div class="footer-section social-icon">
            <img src="Images/WhatsApp.png" alt="WhatsApp" class="social-link">
            <img src="Images/Tiktok.png" alt="Tiktok" class="social-link">
            <img src="Images/x.png" alt="Snapchat" class="social-link">
            <img src="Images/facebook.png" alt="Instagram" class="social-link">
        </div>
        <div class="footer-section">©Hayyakm2034</div>
    </footer>
</body>
</html>
