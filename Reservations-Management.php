<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "databases"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_match'])) {
    $match_id = intval($_POST['match_id']);
    $sql = "DELETE FROM `Matches` WHERE MATCH_ID = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $match_id);
        $stmt->execute();
        $stmt->close();
        header("Location: Reservations-Management.php");
        exit();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$sql = "SELECT MATCH_ID, TEAM1, TEAM2 FROM Matches";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الحجوزات</title>
    <style>
        body {
            font-family: 'Almarai', sans-serif;
            background-color: #0a0213;
            color: white;
            text-align: center;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            margin: auto;
            margin-top: 50px;
        }

        .card {
            background-color: #1a0125;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            text-align: center;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 18px;
            font-weight: bold;
        }

        .delete-btn {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .delete-btn:hover {
            background-color: #e60000;
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
            <img src="Images/Language.png" alt="Language" id="language-icon"></a>        
    </nav>
    <a href="Welcome.html" class="logo">
        <img src="Images/logo1.png" alt="Logo" width="100" height="100"> 
    </a>
</header>

<div class="container">
    <h1>إدارة الحجوزات</h1>
    <h2>المباريات</h2>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
            <p class="match"><?php echo htmlspecialchars($row['TEAM1']) . " vs " . htmlspecialchars($row['TEAM2']); ?></p>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="match_id" value="<?php echo $row['MATCH_ID']; ?>">
                <button type="submit" name="delete_match" class="delete-btn">حذف ✖</button>
            </form>
        </div>
    <?php } ?>
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

</body>
</html>

<?php
$conn->close();
?>
