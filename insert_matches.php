<?php
$conn = new mysqli("localhost", "root", "root", "databases");
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$matches = [
    ['2034-02-12', 'استاد الملك سلمان - نيوم', 'Saudi Arabia', 'Portugal', 'ksa.png', 'السعودية', 'البرتغال', 1],
    ['2034-02-12', 'ملعب الجوهرة - جدة', 'England', 'Germany', 'england.png', 'إنجلترا', 'ألمانيا', 1],
    ['2034-02-13', 'استاد مرسول بارك - الرياض', 'Iran', 'Argentina', 'irann.png', 'إيران', 'الأرجنتين', 2],
    ['2034-02-12', 'استاد الأمير محمد بن فهد - الدمام', 'Uruguay', 'Italy', 'italyy.png', 'أوروغواي', 'إيطاليا', 2],
    ['2034-02-14', 'استاد الملك عبد الله - بريدة', 'England', 'Ecuador', 'englandd.png', 'إنجلترا', 'الإكوادور', 3],
    ['2034-02-12', 'استاد الملك فهد - الرياض', 'Senegal', 'Netherlands', 'Senegal.png', 'السنغال', 'هولندا', 3]
];

$check = $conn->prepare("SELECT MATCH_ID FROM Matches WHERE MATCH_DATE = ? AND TEAM1 = ? AND TEAM2 = ?");
$insert = $conn->prepare("INSERT INTO Matches (MATCH_DATE, VENUE, TEAM1, TEAM2, MATCH_IMAGE, TEAM1_AR, TEAM2_AR, GROUP_ID)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($matches as $match) {
    $check->bind_param("sss", $match[0], $match[2], $match[3]);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $insert->bind_param("sssssssi", $match[0], $match[1], $match[2], $match[3], $match[4], $match[5], $match[6], $match[7]);
        $insert->execute();
    }
}

$check->close();
$insert->close();
echo "تم إدخال البيانات (بدون تكرار أو حذف)";
?>
