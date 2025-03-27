<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo "unauthorized";
    exit;
}

$userId = $_SESSION['user_id'];
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
