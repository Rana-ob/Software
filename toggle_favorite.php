<?php
//مؤقت للتجربة
$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$userId = 1; // مستخدم تجريبي

$check = $conn->prepare("SELECT * FROM Customer WHERE CUSTOMER_ID = ?");
$check->bind_param("i", $userId);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    $name = 'مستخدم تجريبي';
    $phone = 1234567890;
    $email = 'test@hayyakm2034.com';
    $password = password_hash('123456', PASSWORD_DEFAULT); // كلمة مرور مشفرة

    $insert = $conn->prepare("INSERT INTO Customer (CUSTOMER_ID, CUSTOMER_NAME, CUSTOMER_Phone, CUSTOMER_EMAIL, CUSTOMER_PASSWORD) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("isiss", $userId, $name, $phone, $email, $password);

    if ($insert->execute()) {
        echo " تم إنشاء المستخدم بنجاح.";
    } else {
        echo " خطأ أثناء الإضافة: " . $insert->error;
    }

    $insert->close();
} else {
    echo " المستخدم موجود مسبقًا.";
}

$check->close();
$conn->close();

//endd


$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = 1; // مؤقت للتجربة
$matchId = $_POST['match_id'] ?? null;

if (!$matchId) {
    echo "invalid";
    exit;
}

$check = $conn->prepare("SELECT * FROM Favorites WHERE USER_ID = ? AND MATCH_ID = ?");
$check->bind_param("ii", $userId, $matchId);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    $delete = $conn->prepare("DELETE FROM Favorites WHERE USER_ID = ? AND MATCH_ID = ?");
    $delete->bind_param("ii", $userId, $matchId);
    $delete->execute();
    echo "removed";
} else {
    $insert = $conn->prepare("INSERT INTO Favorites (USER_ID, MATCH_ID) VALUES (?, ?)");
    $insert->bind_param("ii", $userId, $matchId);
    $insert->execute();
    echo "added";
}
?>
