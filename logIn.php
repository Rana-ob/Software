<?php
session_start();
$loginError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = new mysqli("localhost", "root", "root", "database");
    if ($conn->connect_error) {
        die("فشل الاتصال: " . $conn->connect_error);
    }

    $loginInput = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT CUSTOMER_ID, CUSTOMER_PASSWORD, USER_TYPE FROM Customer 
                            WHERE CUSTOMER_EMAIL = ? OR CUSTOMER_NAME = ?");
    $stmt->bind_param("ss", $loginInput, $loginInput);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['CUSTOMER_PASSWORD'];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['customer_id'] = $user['CUSTOMER_ID'];

            if ($user['USER_TYPE'] === "admin") {
                header("Location: adminProfile.html");
            } else {
                header("Location: homepage.html");
            }
            exit();
        }
    }

    $loginError = "اسم المستخدم أو كلمة المرور غير صحيحة";

    $stmt->close();
    $conn->close();
}
?>










<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <style>

body {
    background-color: #0a0213;
    color: white;
    font-family: 'Almarai', sans-serif;
    display: flex;
    flex-direction: column; /* Stack header, main content, and footer vertically */
    justify-content: center;
    align-items: center;
    min-height: 100vh; 
    margin: 0;
    direction: rtl;
    padding-top: 80px; 
}

.wrap {
    display: flex;
    flex-direction: row;
    gap: 500px; 
    max-width: 1000px; 
    width: 90%;
    margin-top: 10px;
}


.content {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.text-container {
    font-size: 2em; 
    font-weight: bold;
    line-height: 1.2;
    color: white;
}

.highlight {
    background: linear-gradient(to right, #c8a2c8, #a783c6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.image-container {
    width: 450px; 
    height: 450px; 
    position: relative;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.1);
    margin-top: 5px;
}

.image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.container {
    background-color: #140f1d;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.1);
    width: 100%;
    max-width: 400px; 
}


.headerll {
    display: flex;
    justify-content: center; 
    align-items: center; 
}
.form-box {
    padding: 20px;
    top: 200px;;

}

.input-group {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.input-group input {
    width: 100%;
    padding: 12px;
    border: none;
    background: #1e1931;
    color: white;
    font-size: 16px;
    outline: none;
    border-radius: 16px;
    text-align: right;
}

button {
    width: 100%;
    padding: 14px;
    background-color: #7d3be2;
    border: none;
    color: white;
    border-radius: 12px;
    cursor: pointer;
    font-size: 18px;
    margin-top: 20px;
    transition: 0.3s;
    font-weight: bold;
    font-family: 'Almarai', sans-serif;
}

button:hover {
    background-color: #5a28a5;
}


h2 {
    
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    border: 2px solid #5a28a5;
    border-radius: 20px;
    padding: 10px;
    display: inline-block; 
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
    font-family: 'Almarai', sans-serif;
    
}


p {
    font-size: 14px;
    margin-top: 15px;
    text-align: center;
}

p a {
    color: #c29eff;
    text-decoration: none;
    font-weight: bold;
}
.wrap {
    display: flex;
    align-items: center;
    gap: 100px; 
    max-width: 1000px; 
    width: 90%;
    flex: 1; 
}

/*h--------footer and header----------------------*/

.header {
    position: fixed; 
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    height: 80px;
    justify-content: space-between;
    padding: 15px 30px;
    background-color: #10021d;
    z-index: 1000; /* Ensure the header stays above other content */
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

div {
    margin: 10px 0;
}

label {
    margin-left: 15px;
    font-size: 16px;
}
}.footer {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    background-color: #0b0013;
    color: white;
    padding: 20px;
    border: 1px solid #a144c9;
    border-radius: 10px;
    text-align: center;
    width: 100%; 
    margin-top: 10%; 
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
        <a href="Welcome.html" class="logo">
            <img src="Images/logo1.png" alt="Logo" width="100" height="100"> 
        </a>
        <nav class="nav-links">
            <a href="Welcome.html"> الصفحة الرئيسية  </a>
           
                   

<a href ="#" id="language-link">
    <img src="Images/Language.png" alt="Language" id="language-icon">
</a>        </nav>
    </header>
    <br> <br><br>
    <div class="wrap">
        <div class="container">
            <div class="headerll">
                <h2>  تسجيل الدخول  </h2>
            </div>
            <br>
            <div class="form-box">
            <form class="input-group" id="loginForm" action="login.php" method="POST">
            <input type="text" id="username" name="username" placeholder="البريد الإلكتروني أو اسم المستخدم" required>

    <input type="password" id="password" name="password" placeholder="الرمز السري" required>

    <p>ليس لديك حساب؟ <a href="NewAccount.html">إنشاء حساب</a></p>

    <button type="submit" name="login">سجل الدخول</button>

    <?php
    //  رسالة الخطأً
    if (isset($_POST['login']) && !empty($loginError)) {
        echo "<p style='color:red; font-weight:bold; margin-top: 15px;'> $loginError</p>";
    }
    ?>
</form>

            </div>
        </div>
        
        
        <div class="content">
            <div class="text-container">
                المملكة العربية السعودية<br>
                <span class="highlight">وجهة العالم</span>
            </div>
            <br>
            <div class="image-container">
                <img src="Images/logIn_Image.jpg" alt="cristiano ronaldo">
            </div>
        </div>
             
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