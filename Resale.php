<?php include 'resale_process.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة بيع التذاكر - Hayyakm2034</title>
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
button{
    font-family: 'Almarai', sans-serif;
    
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

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .heroResale h1 {
            text-align: center;
            color: white;
            font-size: xx-large;
        }

        .resale {
            background: #2c113c;
            padding: 20px;
            border-radius: 20px;
            margin: 20px auto;
            width: 80%;
            max-width: 550px;
            box-shadow: 0px 0px 20px rgba(155, 52, 235, 0.7);
        }
        .ticket-option {
            background: white;
            color: black;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            border: 2px solid #9b34eb;
        }
        .confirm-btoon {
            background: #770295;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
        }
        .confirm-btoon:hover {
            background: #7d1fc9;
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
  

    <section class="resale">
        <h2>تستطيع إعادة بيع تذكرتك</h2>
        <p>اختر التذكرة المراد بيعها:</p>
        
        <form method="post" action="resale_process.php">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='ticket-option'>";
                    echo "<input type='checkbox' name='resale_tickets[]' value='" . $row['TICKET_ID'] . "'>";
                    echo "<label> " . $row['TEAM1'] . " × " . $row['TEAM2'] . " - " . $row['MATCH_DATE'] . " - " . $row['PRICE'] . " SAR</label>";
                    echo "</div>";
                }
            } else {
                echo "<p>لا توجد تذاكر متاحة لإعادة البيع.</p>";
            }
            ?>
             <?php if ($tickets_available): ?>
            <button type="submit" class="confirm-btoon">تأكيد البيع</button>
        <?php endif; ?>
        </form>
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