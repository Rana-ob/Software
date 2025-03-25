


<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
//session_start();
//$userId = $_SESSION['user_id'];
$userId = 1; // مؤقتًا للتجربة

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['match_id'])) {
    $matchId = $_POST['match_id'];

    $stmt = $conn->prepare("DELETE FROM Favorites WHERE USER_ID = ? AND MATCH_ID = ?");
    $stmt->bind_param("ii", $userId, $matchId);
    $stmt->execute();
    $stmt->close();
}

header("Location: personalfile.php"); 
exit();
?>
