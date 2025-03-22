<?php
$servername = "localhost"; 
$username = "root"; 
$password = "root"; 
$dbname = "DatabaseS"; 

$conn = new mysqli($servername, $username, $password, $dbname , "8889");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// **Delete User (if delete button is clicked)**
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_sql = "DELETE FROM Customer WHERE CUSTOMER_ID = ?";
    
    if ($stmt = $conn->prepare($delete_sql)) {
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "<script>alert('User deleted successfully'); window.location.href='index.php';</script>";
        } else {
            echo "Error deleting user: " . $conn->error;
        }
        $stmt->close();
    }
}

// **Fetch All Customers from Database**
$sql = "SELECT CUSTOMER_ID, CUSTOMER_NAME, CUSTOMER_EMAIL FROM Customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <title>إدارة المستخدمين</title>
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
            text-align: right;
        }
        .card p {
            font-size: 18px;
        }
        .email {
            color: rgb(185, 200, 209);
        }
        .delete-btn {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        /* Header Style */
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

        /* Footer Style */
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
            <img src="Images/Language.png" alt="Language" id="language-icon">
        </a>        
    </nav>
    <a href="Welcome.html" class="logo">
        <img src="Images/logo1.png" alt="Logo">
    </a>
</header>

<div class="container">
    <h1>إدارة المستخدمين</h1>
    <h2>المستخدمون</h2>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card">';
            echo '<p><strong>الاسم:</strong> ' . htmlspecialchars($row['CUSTOMER_NAME']) . '</p>';
            echo '<p><strong>البريد الإلكتروني:</strong> <span class="email">' . htmlspecialchars($row['CUSTOMER_EMAIL']) . '</span></p>';
            echo '<form method="post">';
            echo '<input type="hidden" name="delete_id" value="' . $row['CUSTOMER_ID'] . '">';
            echo '<button type="submit" class="delete-btn">حذف ✖</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "<p>لا يوجد مستخدمون.</p>";
    }
    ?>
</div>

<footer class="footer">
    <div class="footer-section footer-logo">
        <img src="Images/logo1.png" alt="Hayyakm 2034">
    </div>
    <div class="footer-section">Contact</div>
    <div class="footer-section">Hayyakm2034@gmail.com</div>
    <div class="footer-section">Services</div>
    <div class="footer-section">
        <div class="footer-icons">
            <a href="#"><img src="Images/WhatsApp.png" alt="WhatsApp" class="social-link"></a>
            <a href="#"><img src="Images/Tiktok.png" alt="Tiktok" class="social-link"></a>
            <a href="#"><img src="Images/x.png" alt="Snapchat" class="social-link"></a>
            <a href="#"><img src="Images/facebook.png" alt="Instagram" class="social-link"></a>
        </div>
    </div>
    <div class="footer-section">©Hayyakm2034</div>
</footer>

<?php
$conn->close(); // Close database connection
?>

</body>
</html>
