<?php
$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $reservation_id = intval($_GET['id']);

    // جلب بيانات الحجز
    $query = "SELECT * FROM reservation_ticket WHERE RESERVATION_ID = $reservation_id";
    $result = $conn->query($query);
    $booking = $result->fetch_assoc();

    if (!$booking) {
        die("الحجز غير موجود.");
    }
} else {
    die("رقم الحجز غير محدد.");
}

// تحديث البيانات بعد الإرسال
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = intval($_POST['guests']);

    $updateQuery = "UPDATE reservation_ticket SET DATE='$date', TIME='$time', NUMBER_OF_GUESTS=$guests WHERE RESERVATION_ID=$reservation_id";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('تم تحديث الحجز بنجاح!'); window.location='personalfile.php';</script>";
    } else {
        echo "خطأ في التحديث: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل الحجز</title>
    <link rel="stylesheet" href="s1.css">
</head>
<body>

<div class="container">
    <h2>تعديل الحجز</h2>
    <form method="POST">
        <label>تاريخ الحجز</label>
        <input type="date" name="date" value="<?= $booking['DATE'] ?>" required>

        <label>وقت الحجز</label>
        <input type="time" name="time" value="<?= $booking['TIME'] ?>" required>

        <label>عدد الضيوف</label>
        <input type="number" name="guests" value="<?= $booking['NUMBER_OF_GUESTS'] ?>" min="1" required>

        <button type="submit">حفظ التعديلات</button>
    </form>
</div>

</body>
</html>
