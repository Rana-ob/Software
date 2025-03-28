<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$customerId = $_SESSION['customer_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['phone'])) {
    $newPhone = $_POST['phone'];
    $update = $conn->prepare("UPDATE Customer SET CUSTOMER_PHONE = ? WHERE CUSTOMER_ID = ?");
    $update->bind_param("si", $newPhone, $customerId);
    $update->execute();
    $update->close();
}

$stmt = $conn->prepare("SELECT CUSTOMER_NAME, CUSTOMER_EMAIL, CUSTOMER_USERNAME, CUSTOMER_PHONE FROM Customer WHERE CUSTOMER_ID = ?");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $userData = $result->fetch_assoc();
} else {
    echo "لم يتم العثور على معلومات المستخدم.";
    exit();
}

$stmt->close();
$conn->close();
?>





<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>transport</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <style>
           @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;700&display=swap');
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




/*h--------footer and header----------------------*/

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
        max-width: 100%;
        text-align: center;
        height: 150px;
        margin-top: auto; 
    
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
    position: relative;
    bottom: 0;  
    left: 0;
    transform: none;  
}
.social-link { 
    width: 30px;   
    height: 30px; 
    border-radius: 50%;  
    padding: 10px;  
    background-color: #bababa;  
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);   
    transition: transform 0.3s ease;   
    position: static; 
} 
.social-link:hover { 
    transform: scale(1.1);   
    background-color: #f0eded; 
} 


.container {
            max-width: 400px;
            margin: auto;
        }

        h2 {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            text-align: right;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 10px;
            border: none;
            background: #2C2A3A;
            color: white;
            text-align: right;
        }

        .admin-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
        }
        button {
            background-color: #3a3a3a;
            border: 1px solid #555;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            color: white;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background: #555;
            transform: scale(1.02);
        }


    </style>

</head>
<body>

    <header class="header">
        <a href="Welcome.html" class="logo">
            <img src="Images/logo1.png" alt="Logo" width="100" height="100"> 
        </a>
        <nav class="nav-links">
           
            <a href ="#" id="language-link">
            <img src="Images/Language.png" alt="Language" id="language-icon"></a>        
        </nav>
    </header>
    <br>
    <div class="container">
        <section class="profile">
            <h2>الملف الشخصي للمدير</h2>
            <label>الاسم كامل</label>
            <input type="text" value="<?php echo htmlspecialchars($userData['CUSTOMER_NAME']); ?>" readonly>

            <label>البريد الإلكتروني</label>
            <input type="email" value="<?php echo htmlspecialchars($userData['CUSTOMER_EMAIL']); ?>" readonly>

            <label>اسم المستخدم</label>
            <input type="text" value="<?php echo htmlspecialchars($userData['CUSTOMER_USERNAME']); ?>" readonly>
            <form method="post" action="">
            <label>رقم الهاتف</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($userData['CUSTOMER_PHONE'] ?? ''); ?>">
        </form>

            
        </section>

        <section class="admin-actions">
            <h2>إدارة النظام</h2>
            <a href="User-management.php"><button class="manage">إدارة المستخدمين</button></a>
            <a href="Reservations-Management.php"><button class="manage">إدارة الحجوزات</button></a>
        </section>
    </div>

    <script>
        document.getElementById("phoneInput").addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault(); 
                this.form.submit(); 
            }
        });
        </script>

      
    <br><br>
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