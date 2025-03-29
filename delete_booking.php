<?php
$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $reservation_id = intval($_GET['id']);

    // حذف الحجز المحدد
    $deleteQuery = "DELETE FROM reservation_ticket WHERE RESERVATION_ID = $reservation_id";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('تم حذف الحجز بنجاح'); window.location='personalfile.php';</script>";
    } else {
        echo "حدث خطأ: " . $conn->error;
    }
} else {
    echo "رقم الحجز غير موجود.";
}

$conn->close();
?>
