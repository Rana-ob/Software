<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$stations = [];
$sql = "SELECT * FROM transport WHERE LAT IS NOT NULL AND LNG IS NOT NULL";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $stations[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>المواصلات</title>
    <link rel="stylesheet" href="s2.css">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        .transport-options img {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
        }
        
        
        
        .booking-btn {
    background: linear-gradient(135deg, #a855f7, #9333ea);
    color: #fff;
    padding: 14px 38px;
    font-size: 18px;
    border: none;
    border-radius: 40px;
    cursor: pointer;
    font-family: 'Almarai', sans-serif;
    font-weight: bold;
    box-shadow: 0 6px 20px rgba(168, 85, 247, 0.4);
    transition: all 0.3s ease;
    letter-spacing: 1px;
    margin-top: 25px;
}

.booking-btn:hover {
    background: linear-gradient(135deg, #9333ea, #a855f7);
    transform: scale(1.07);
    box-shadow: 0 10px 25px rgba(168, 85, 247, 0.6);
}

    </style>
</head>
<body>

<header class="header">
    <a href="homepage.html" class="logo">
        <img src="logo1.png" alt="Logo" width="100" height="100"> 
    </a>
    <nav class="nav-links">
        <a href="match_1.html">مباريات</a>
        <a href="Entertimante.html">ترفية ومناطق التشجيع</a>
        <a href="tranrport2.html">المواصلات</a>
        <a href ="#" id="language-link">
            <img src="Language.png" alt="Language" id="language-icon">
        </a>        
    </nav>
</header>

<section class="destination-section">
    <h2>وسائل النقل القريبة منك</h2>
    <div class="search-box">
        <div class="input-container">
            <input type="text" id="start-input" placeholder="نقطة الانطلاق" aria-label="نقطة الانطلاق">
            <div class="location-markers">
                <div class="marker marker-top"></div>
                <div class="dashed-line"></div>
                <div class="marker marker-bottom"></div>
            </div>
        </div>
        <div class="input-container">
            <input type="text" id="end-input" placeholder="نقطة الوصول" aria-label="نقطة الوصول">
        </div>
        <button onclick="locateUserInput()" class="swap-btn">تحديد المواقع</button>
    </div>
</section>

<section class="map-container">
    <div id="map" style="height: 400px; width: 100%;"></div>
</section>

<section class="transport-buttons">
    <button class="bus-btn" onclick="showNearest('bus')">🚌 Bus</button>
    <span class="separator"></span>
    <button class="metro-btn" onclick="showNearest('metro')">🚇 Metro</button>
</section>

<section class="private-transport">
    <h2>حدد وسيلة النقل الخاصة بك</h2>
    <div class="transport-options">
        <div class="option bike" onclick="showNearest('bike')">
            <img src="bi.png" alt="دراجة هوائية">
            دراجة هوائية
        </div>
        <div class="option taxi" onclick="showNearest('taxi')">
            <img src="ra.png" alt="تاكسي">
            تاكسي
        </div>
        <div class="option careem" onclick="window.open('https://www.careem.com/', '_blank')">
            <img src="kareem.png" alt="كريم">
            كريم
        </div>
        <div class="option uber" onclick="window.open('https://www.uber.com/', '_blank')">
            <img src="ub.png" alt="أوبر">
            أوبر
        </div>
    </div>
</section>
<section id="booking-section" style="display: none; text-align:center; margin: 30px;">
   <form action="payment.php" method="POST">
    <input type="hidden" name="from" id="from-input">
    <input type="hidden" name="to" id="to-input">
    <input type="hidden" name="type" id="type-input">
    <button type="submit" class="booking-btn">احجز هذه الوسيلة</button>
</form>

</section>

<footer class="footer">
    <div class="footer-section footer-logo">
        <img src="logo1.png" alt="Hayyakm 2034">
    </div>
    <div class="footer-section">Contact</div>
    <div class="footer-section">Hayyakm2034@gmail.com</div>
    <div class="footer-section">Services</div>
    <div class="footer-section social-icon">
        <img src="WhatsApp.png" alt="WhatsApp" class="social-link">
        <img src="Tiktok.png" alt="Tiktok" class="social-link">
        <img src="x.png" alt="Snapchat" class="social-link">
        <img src="facebook.png" alt="Instagram" class="social-link">
    </div>
    <div class="footer-section">©Hayyakm2034</div>
</footer>

<script>
const stations = <?php echo json_encode($stations); ?>;
let userLocation = null;
let map = L.map('map').setView([24.7136, 46.6753], 13);
let stationMarker = null;
let userMarker = null;

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data © OpenStreetMap contributors'
}).addTo(map);

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(position => {
        userLocation = [position.coords.latitude, position.coords.longitude];
        userMarker = L.marker(userLocation).addTo(map).bindPopup('موقعك الحالي').openPopup();
        map.setView(userLocation, 14);
    }, () => {
        alert("لم نتمكن من تحديد موقعك تلقائيًا، يمكنك إدخاله يدويًا");
    });
} else {
    alert("المتصفح لا يدعم تحديد الموقع الجغرافي");
}

function locateUserInput() {
    const startText = document.getElementById("start-input").value;
    if (!startText) {
        alert("يرجى إدخال نقطة الانطلاق");
        return;
    }
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(startText)}`)
        .then(res => res.json())
        .then(data => {
            if (data.length > 0) {
                userLocation = [parseFloat(data[0].lat), parseFloat(data[0].lon)];
                if (userMarker) userMarker.remove();
                userMarker = L.marker(userLocation).addTo(map).bindPopup("موقع الانطلاق").openPopup();
                map.setView(userLocation, 14);
            } else {
                alert("لم يتم العثور على الموقع");
            }
        });
}

function showNearest(type) {
    if (!userLocation) {
        alert("يرجى تحديد موقعك أولاً");
        return;
    }

    let nearest = null;
    let minDist = Infinity;

    stations.forEach(station => {
        if (station.TRANSPORT_TYPE === type) {
            const dist = getDistance(userLocation, [station.LAT, station.LNG]);
            if (dist < minDist) {
                minDist = dist;
                nearest = station;
            }
        }
    });

    if (nearest) {
        if (stationMarker) map.removeLayer(stationMarker);
        stationMarker = L.marker([nearest.LAT, nearest.LNG]).addTo(map)
            .bindPopup("أقرب " + getTransportLabel(type) + "<br>من: " + nearest.DEPARTURE_TIME + "<br>إلى: " + nearest.ARRIVAL_TIME + "<br>السعر: " + nearest.PRICE + " ريال")
            .openPopup();
        map.setView([nearest.LAT, nearest.LNG], 15);

        // 🟡 هنا نعرض زر الحجز ونعبّي البيانات
        document.getElementById("from-input").value = document.getElementById("start-input").value;
        document.getElementById("to-input").value = document.getElementById("end-input").value;
        document.getElementById("type-input").value = type;
        document.getElementById("booking-section").style.display = "block";
    }
}

function getTransportLabel(type) {
    switch(type) {
        case 'bus': return 'باص 🚌';
        case 'metro': return 'مترو 🚇';
        case 'taxi': return 'تاكسي 🚖';
        case 'bike': return 'دراجة هوائية 🚴‍♀️';
        default: return 'مواصلات';
    }
}

function getDistance(a, b) {
    const R = 6371;
    const dLat = toRad(b[0] - a[0]);
    const dLon = toRad(b[1] - a[1]);
    const lat1 = toRad(a[0]);
    const lat2 = toRad(b[0]);
    const aComp = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
    const c = 2 * Math.atan2(Math.sqrt(aComp), Math.sqrt(1-aComp));
    return R * c;
}

function toRad(Value) {
    return Value * Math.PI / 180;
}
</script>
</body>
</html>
