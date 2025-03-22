<?php
// هنا يمكن إضافة الكود الخاص بإدارة المدفوعات
// على سبيل المثال، هنا يتم إضافة كود لمعالجة المدفوعات عند الضغط على زر "إضافة"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // هنا يمكنك إضافة الكود لتحويل البيانات المدخلة إلى قاعدة بيانات أو معالجتها
    $premium_quantity = isset($_POST['premium_quantity']) ? $_POST['premium_quantity'] : 0;
    $vip_box_quantity = isset($_POST['vip_box_quantity']) ? $_POST['vip_box_quantity'] : 0;
    $silver_quantity = isset($_POST['silver_quantity']) ? $_POST['silver_quantity'] : 0;

}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <title>إدارة المدفوعات</title>
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #0a0213;
            color: white;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        button {
            font-family: 'Almarai', sans-serif;
        }

        .container {
            width: 50%;
            margin: auto;
            margin-top: 50px;
        }

        .card {
            background-color: #1a0125;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .package-name {
            font-size: 18px;
            font-weight: bold;
        }

        .controls {
            display: flex;
            align-items: center;
        }

        .button {
            background-color: gray;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            margin: 0 5px;
            cursor: pointer;
        }

        .add-btn {
            background-color: purple;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .quantity {
            width: 50px;
            text-align: center;
            font-size: 16px;
            margin: 0 5px;
            padding: 5px;
            border-radius: 5px;
            border: none;
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

        #language-link img {
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
        <nav class="nav-links">
            <a href="#" id="language-link">
                <img src="Images/Language.png" alt="Language" id="language-icon"></a>
        </nav>
        <a href="Welcome.html" class="logo">
            <img src="Images/logo1.png" alt="Logo" width="100" height="100">
        </a>
    </header>

    <div class="container">
        <h1>إدارة المدفوعات</h1>
        <form method="POST">
            <div class="card">
                <div class="controls">
                    <input type="number" class="quantity" value="<?php echo isset($premium_quantity) ? $premium_quantity : 0; ?>" name="premium_quantity" min="0">
                </div>
                <p class="package-name">Premium</p>
                <button type="submit" class="add-btn">إضافة</button>
            </div>
            <div class="card">
                <div class="controls">
                    <input type="number" class="quantity" value="<?php echo isset($vip_box_quantity) ? $vip_box_quantity : 0; ?>" name="vip_box_quantity" min="0">
                </div>
                <p class="package-name">VIP BOX</p>
                <button type="submit" class="add-btn">إضافة</button>
            </div>
            <div class="card">
                <div class="controls">
                    <input type="number" class="quantity" value="<?php echo isset($silver_quantity) ? $silver_quantity : 0; ?>" name="silver_quantity" min="0">
                </div>
                <p class="package-name">SILVER</p>
                <button type="submit" class="add-btn">إضافة</button>
            </div>
        </form>
    </div>

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
