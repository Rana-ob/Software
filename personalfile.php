<?php
$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//session_start();
//$userId = $_SESSION['user_id'];
$userId = 1; // مؤقتًا للتجربة

$sql = "SELECT M.* FROM Matches M 
        JOIN Favorites F ON M.MATCH_ID = F.MATCH_ID 
        WHERE F.USER_ID = $userId";
$result = $conn->query($sql);
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
           
            <a href="personalfile.html">الملف الشخصي </a>
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
            <input type="text" value="رنا " readonly>
            
            <label>البريد الإلكتروني</label>
            <input type="email" value="RanaSalem5@gmail.com" readonly>
            
            <label>رقم الهاتف (اختياري)</label>
            <input type="text" value="050196317" readonly>
        </section>

        <section class="bookings">
            <br>
            <h2>الحجوزات</h2>
            <div class="booking-card">
                <p><strong>السعودية × البرتغال</strong></p>
                <p>12-FEB-2034 | Sunday | 9:00 PM</p>
                <p>ملعب: أستاذ نيوم</p>
                <div class="actions">
                    <button class="edit">تعديل ✏️</button>
                    <button class="delete">حذف ❌</button>
                </div>
            </div>
        </section>
          <br><!-- comment -->
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
                <?php while($row = $result->fetch_assoc()) { ?>
                    <div class="booking-card">
                        <p><strong><?= $row['TEAM1'] ?> × <?= $row['TEAM2'] ?></strong></p>
                        <p><?= $row['MATCH_DATE'] ?></p>
                        <p>الملعب: <?= $row['VENUE'] ?></p>
                        <div class="actions">
                            <form method="POST" action="remove_favorite.php">
                                <input type="hidden" name="match_id" value="<?= $row['MATCH_ID'] ?>">
                                <button type="submit" class="delete">حذف ❌</button>
                            </form>
                        </div>
                    </div>
                    <br>
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
