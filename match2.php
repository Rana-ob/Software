<?php
$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("معرف المباراة غير موجود.");
}

$matchId = intval($_GET['id']); 

$stmt = $conn->prepare("SELECT * FROM Matches WHERE MATCH_ID = ?");
$stmt->bind_param("i", $matchId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("لم يتم العثور على المباراة.");
}

$match = $result->fetch_assoc(); 
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">

    <title>حجز تذاكر كأس العالم 2034</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">

<style>

        body {
            
     background-color: #0a0213;
    color: white;
    margin: 0;
    padding: 0;
    text-align: center;
    font-family: 'Almarai', sans-serif;

        }
        .match-info {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            padding: 20px;
        }
        .match-info img {
            width: 100px;
            height: 65px;
            border-radius: 10px;
        }
        .details {
            text-align: center;
        }
        .stadium {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .stadium img {
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
        }
        .ticket-options {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }
        .ticket {
            background-color: transparent;
            padding: 15px;
            border-radius: 10px;
            width: 200px;
            text-align: center;
            border: 2px solid #8a2be2;
            position: relative;
        }
        .ticket p {
            font-size: 18px;
        }
        .ticket button {
            background-color: #8a2be2;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
            width: 80%;
            font-size: 16px;
            font-family: 'Almarai', sans-serif;
        }
        .ticket button:hover {
            background-color: #a14ae3;
        }
        .ticket .seat-3d {
            position: absolute;
            top: 10px;
            left: 10px;
            
            color: white;
            padding: 5px 10px;
          
            font-size: 14px;
            
            background-color: #4c2b5e;
           
            border: none;
          
            border-radius: 20px;
            cursor: pointer;
         
        }
        .seat-3d:hover {
            background-color: #8a2be2; 
        }
        .ticket .ticket-type {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #d1c9d9;
        }
        .ticket .description {
            color: orange;
            font-size: 14px;
            margin-top: 5px;
        }
        .terms, .suggestions {
            margin-top: 40px;
        }
        .suggestions button {
            color: white;
            padding: 12px;
            margin: 10px;
            border-radius: 8px;
            width: 180px;
            font-size: 16px;
            background-color: transparent;
            margin-right: 70px;
            margin-left: 70px;
            font-family: 'Almarai', sans-serif;
        }
        .suggestions button:hover{
            background: rgba(255, 255, 255, 0.1);        }
        .cheering {
            border: 1px solid yellow;
        }
        .transportation {
            border: 1px solid red;
        }

        .header {
    display: flex;
    align-items: center;
    height: 80px;
    justify-content: space-between;
    padding: 15px 30px;
    background-color:  #10021d;
}

.logo {
    display: flex;
    align-items: center;
    color: white;
    font-size: 18px;
    font-weight: bold;
    text-decoration: none;
}

.logo img {
    width: 200px;
    height: 200px;
    object-fit: contain;
    
}
#language-link img{
    width: 40px;
    height: 35px;

}
.nav-links {
    display: flex;
    gap: 20px;
}

.nav-links a {
    text-decoration: none;
    color: white;
    font-size: 16px;
    padding: 8px 12px;
    border-radius: 20px;
    transition: background 0.3s ease;
}

.nav-links a:hover {
    background: rgba(255, 255, 255, 0.1);
}
.footer {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    background-color: #0b0013;
    color: white;
    padding: 20px;
    border: 1px solid #a144c9;
    border-radius: 10px;
    width: 100%;
    text-align: center;
    margin-top: 30%; 
}

        .footer-logo img {
            width: 150px;
            height: 150px;
            object-fit: contain;
        }

        .footer-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .footer-icons a {
            color: white;
            text-decoration: none;
            font-size: 20px;
        }

        .social-icons {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 20px;
            padding: 10px;
        }

        .social-link {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            padding: 10px;
            background-color: #bababa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .social-link:hover {
            transform: scale(1.1);
            background-color: #f0eded;
        }
    </style>
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
    <img src="Images/Language.png" alt="Language" id="language-icon">
</a>        </nav>
    </header>
    <div class="match-info" style="flex-direction: column;">
    <img src="Images/<?php echo $match['MATCH_IMAGE']; ?>" alt="<?php echo $match['TEAM1']; ?> vs <?php echo $match['TEAM2']; ?>" style="width: 320px; height: auto; border-radius: 10px; margin-bottom: 15px;">
    
    <div class="details">
        <p><?php echo htmlspecialchars($match['TEAM1_AR']); ?> × <?php echo htmlspecialchars($match['TEAM2_AR']); ?></p>
        <p style="font-size: larger;"><?php echo htmlspecialchars($match['MATCH_TIME']); ?></p>                
        <p style="font-size: larger;"><?php echo htmlspecialchars($match['VENUE']); ?></p>                
    </div>
</div>
    
    <section class="tickets">
        <h2>التذاكر</h2>
        <div class="stadium">
            <img src="Images/stadium-layout.jpg" alt="مخطط الملعب">
        </div>
        <section class="terms">
            <h3>الشروط والأحكام</h3>
            <p>عند شراء هذه التذكرة فأنت موافق على الشروط والأحكام</p>
            <input type="checkbox" id="agree" name="terms" checked> <label for="agree">أوافق   </label>
        </section>
        <div class="ticket-options">
            <div class="ticket premium">
                <span class="ticket-type">Premium</span>
                <br>
                <span class="seat-3d">3D Seat</span>
                <p>﷼ 600</p>
                <p class="description"> مميزة مع رؤية واضحة للملعب</p>
                <button>احجز الآن</button>
            </div>
            <div class="ticket silver">
                <span class="ticket-type">Silver</span>
                <br>
                <span class="seat-3d">3D Seat</span>
                <p>﷼ 300</p>
                <p class="description">خيار اقتصادي بإطلالة جيدة</p>
                <a href="match3.html">
                    <button>احجز الآن</button>
                </a>
            </div>
            <div class="ticket vip">
                <span class="ticket-type">VIP BOX</span>
                <br>
                <span class="seat-3d">3D Seat</span>
                <p>﷼ 11000</p>
                <p class="description">تجربة فاخرة وخدمات حصرية</p>
                <button>احجز الآن</button>
            </div>
        </div>
    </section>
 
    <section class="suggestions">
        <h3>مقترحات لأجلك</h3>
        <a href="Entertimante.html">  <button class="cheering" >مناطق التشجيع</button> </a>
        <a href="tranrport2.html">  <button class="transportation">المواصلات</button></a>
    </section>

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
