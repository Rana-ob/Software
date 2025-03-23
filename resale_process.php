<?php
session_start();
$servername = "localhost"; 
$username = "root"; 
$password = "root"; 
$dbname = "DatabaseS"; 

$conn = new mysqli($servername, $username, $password, $dbname , "8889");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT Ticket.TICKET_ID, Match.TEAM1, Match.TEAM2, Match.MATCH_DATE, Ticket.PRICE 
          FROM Ticket
          JOIN Reservation_Ticket ON Ticket.RESERVATION_ID = Reservation_Ticket.RESERVATION_ID
          JOIN Match ON Reservation_Ticket.MATCH_ID = Match.MATCH_ID
          WHERE Ticket.RESALE_TICKET = 0"; // Fetch only non-resold tickets

$result = $conn->query($query);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resale_tickets'])) {
    foreach ($_POST['resale_tickets'] as $ticket_id) {
        // Update ticket resale status
        $update_query = "UPDATE Ticket SET RESALE_TICKET = 1 WHERE TICKET_ID = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
    }
    echo "<script>alert('تمت إعادة بيع التذكرة بنجاح!'); window.location.href='resale.php';</script>";
}
?>
