<?php
// Database connection
$host = 'localhost';
$dbname = 'DataBaseS';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

// Check if POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $fullName = htmlspecialchars(trim($_POST["fullName"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars(trim($_POST["username"]));
    $password = trim($_POST["password"]);
    $userType = $_POST["userType"] ?? null;

    // Validate required fields
    if (empty($fullName) || empty($email) || empty($username) || empty($password) || !$userType) {
        echo "الرجاء ملء جميع الحقول المطلوبة.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
    $stmt->execute(['email' => $email, 'username' => $username]);

    if ($stmt->rowCount() > 0) {
        echo "اسم المستخدم أو البريد الإلكتروني مسجل مسبقاً.";
        exit;
    }

    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, username, password, user_type) VALUES (:fullName, :email, :username, :password, :userType)");
    $stmt->execute([
        'fullName' => $fullName,
        'email' => $email,
        'username' => $username,
        'password' => $hashedPassword,
        'userType' => $userType
    ]);

    // Redirect after success
    if ($userType === 'admin') {
        header("Location: adminProfile.html");
    } else {
        header("Location: homepage.html");
    }
    exit;
}
?>
