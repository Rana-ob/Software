<?php
session_start();

$conn = new mysqli("localhost", "root", "root", "database");

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$userId = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;

if (isset($_GET['query']) && trim($_GET['query']) !== "") {
    $search = $_GET['query'];
    $like = "%$search%";

    $sql = "SELECT M.*, 
            (SELECT 1 FROM Favorites F WHERE F.USER_ID = ? AND F.MATCH_ID = M.MATCH_ID) AS is_favorite 
            FROM Matches M
            WHERE LOWER(M.TEAM1) LIKE LOWER(?) 
            OR LOWER(M.TEAM2) LIKE LOWER(?) 
            OR M.TEAM1_AR LIKE ? 
            OR M.TEAM2_AR LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $userId, $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();

    $matches = [];
    while ($row = $result->fetch_assoc()) {
        $row['is_favorite'] = $row['is_favorite'] == 1 ? true : false;
        $matches[] = $row;
    }

    echo json_encode($matches);
} else {
    echo json_encode([]);
}
exit();

?>
