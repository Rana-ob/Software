<?php
session_start();

$conn = new mysqli("localhost", "root", "root", "database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التأكد من أن المستخدم مسجل دخول
$userId = isset($_SESSION['customer_id']) ? (int)$_SESSION['customer_id'] : 0;

$sql = "SELECT M.*,
        (SELECT 1 FROM Favorites F WHERE F.USER_ID = $userId AND F.MATCH_ID = M.MATCH_ID LIMIT 1) AS is_favorite
        FROM Matches M
        WHERE M.GROUP_ID IN (1, 2)";

$result = $conn->query($sql);

$group1 = [];
$group2 = [];

while ($row = $result->fetch_assoc()) {
    if ($row['GROUP_ID'] == 1) {
        $group1[] = $row;
    } else if ($row['GROUP_ID'] == 2) {
        $group2[] = $row;
    }
}
?>

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hayyakm2034</title>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
  font-family: 'Almarai', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #0a0213;
    color: white;
    margin: 0;
    padding: 0;
    text-align: center;
}


/*h--------footer and header----------------------*/

.header {
    display: flex;
    align-items: center;
    height: 80px;
    justify-content: space-between;
    padding: 15px 30px;
    background-color:  #10021d;
}

.logo {
    display: flex;
    align-items: center;
    color: white;
    font-size: 18px;
    font-weight: bold;
    text-decoration: none;
}

.logo img {
    width: 200px;
    height: 200px;
    object-fit: contain;
    
}
#language-link img{
    width: 40px;
    height: 35px;

}
.nav-links {
    display: flex;
    gap: 20px;
}

.nav-links a {
    text-decoration: none;
    color: white;
    font-size: 16px;
    padding: 8px 12px;
    border-radius: 20px;
    transition: background 0.3s ease;
}

.nav-links a:hover {
    background: rgba(255, 255, 255, 0.1);
}


.footer {
   
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        background-color: #0b0013;
        color: white;
        padding: 20px;
        border: 1px solid #a144c9;
        border-radius: 10px;
        max-width: 100%;
        text-align: center;
        height: 150px;
        margin-top: auto; 
    
}
.footer-logo img {
    width: 150px;
    height: 150px;
    object-fit: contain;
}
.footer-section {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}
.footer-icons {
    display: flex;
    justify-content: center;
    gap: 15px;
}
.footer-icons a {
    color: white;
    text-decoration: none;
    font-size: 20px;
}
.social-icons { 
    display: flex; 
    flex-direction: row; 
    justify-content: center;  
    align-items: center; 
    gap: 20px;  
    padding: 10px; 
    position: relative;
    bottom: 0;  
    left: 0;
    transform: none;  
}
.social-link { 
    width: 30px;   
    height: 30px; 
    border-radius: 50%;  
    padding: 10px;  
    background-color: #bababa;  
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);   
    transition: transform 0.3s ease;   
    position: static; 
} 
.social-link:hover { 
    transform: scale(1.1);   
    background-color: #f0eded; 
} 
/* -- match1-- */

.match-card1 {
    position: relative;
    width: 90%;
    max-width: 1000px;
    margin: auto;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0px 0px 30px rgba(255, 255, 255, 0.1);
}

.match-card1 img {
    width: 100%;
    height: auto;
    display: block;
}

.btn-book {
    position: absolute;
    bottom: 1px;  
    background: #6a0dad;
    color: white;
    border: none;
    padding: 12px 20px;
    cursor: pointer;
    border-radius: 8px;
    font-size: 18px;
    right: 1px;
    font-family: 'Almarai', sans-serif;
}

.btn-book:hover {
    background: #a77acb;
}

        .search-container {
            margin: 30px auto;
            width: 60%;
            max-width: 600px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 10px 20px;
            color: white;
            font-size: 18px;
        }

        .search-container img {
    width: 25px;
    cursor: pointer;
}
    
.matches {
            display: flex;
            justify-content: center;
            gap: 80px;
            padding: 20px;
            flex-wrap: wrap;
        }

        .match-card {
            background: #1d072fc2;
            padding: 20px;
            border-radius: 10px;
            width: 320px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .match-card img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .match-card button {
            background: #6a0dad;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            font-family: 'Almarai', sans-serif;
        }

        .match-card button:hover {
            background: #a77acb;    
        }

        .bookmark {
        background-image: url('Images/bookmark.png');
        width: 24px;
        height: 24px;
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        background-size: cover;
        transition: transform 0.2s ease;
}
        .bookmark.active {
            background-image: url('Images/bookmark-white.png');
        }

        .bookmark:hover {
            transform: scale(1.2);
            opacity: 0.8;
        }

        h2 {
            text-align: right;
            margin-right: 350px;
        }
        .match-card p,
        .match-card button,
        .match-card1 p,
        .match-card1 button {
        font-family: 'Almarai', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        font-weight: bold;
        }


    </style>

</head>
<body>

    <header class="header">
        <a href="homepage.html" class="logo">
            <img src="Images/logo1.png" alt="Logo" width="100" height="100"> 
        </a>
        <nav class="nav-links">
    
            <a href="personalfile.html">الملف الشخصي </a>
            <a href="match_1.html">مباريات</a>
            <a href="Entertimante.html">ترفيه ومناطق التشجيع</a>
            <a href="tranrport2.html">المواصلات</a>

<a href ="#" id="language-link">
    <img src="Images/Language.png" alt="Language" id="language-icon">
</a>        </nav>
    </header>
    <br>

<!-- الكارد الأساسي -->
<div class="match-card1">
    <img src="Images/match1_image1.png" alt="Match Image">
    <button class="btn-book" onclick="goToMatch('2', 'England', 'Germany', 'englandd.png')">احجز الآن</button>

</div>

<!-- البحث -->
<div class="search-container">
    <input id="searchInput" type="text" placeholder="ابحث عن فريق..." style="border: none; outline: none; background: transparent; color: white; font-size: 18px; width: 100%;">
    <img src="Images/search-icon.png" alt="بحث">
</div>

<!-- مجموعة ١ -->
<h2 id="group1Title">مجموعة ١</h2>
<div class="matches" id="group1">
    <?php foreach ($group1 as $row) { ?>
        <div class="match-card">
        <div class="bookmark <?= $row['is_favorite'] ? 'active' : '' ?>" data-id="<?= $row['MATCH_ID'] ?>"></div>
        <img src="Images/<?= $row['MATCH_IMAGE'] ?>" alt="<?= $row['TEAM1'] ?> vs <?= $row['TEAM2'] ?>">
            <p><?= $row['TEAM1'] ?> × <?= $row['TEAM2'] ?></p>
            <p><?= $row['MATCH_DATE'] ?> | <?= $row['VENUE'] ?></p>
            <button onclick="goToMatch('<?= $row['MATCH_ID'] ?>')">احجز الآن</button>

        </div>
    <?php } ?>
</div>

<!-- مجموعة ٢ -->
<h2 id="group2Title">مجموعة ٢</h2>
<div class="matches" id="group2">
    <?php foreach ($group2 as $row) { ?>
        <div class="match-card">
        <div class="bookmark <?= $row['is_favorite'] ? 'active' : '' ?>" data-id="<?= $row['MATCH_ID'] ?>"></div>
        <img src="Images/<?= $row['MATCH_IMAGE'] ?>" alt="<?= $row['TEAM1'] ?> vs <?= $row['TEAM2'] ?>">
            <p><?= $row['TEAM1'] ?> × <?= $row['TEAM2'] ?></p>
            <p><?= $row['MATCH_DATE'] ?> | <?= $row['VENUE'] ?></p>
            <button onclick="goToMatch('<?= $row['MATCH_ID'] ?>')">احجز الآن</button>

        </div>
    <?php } ?>
</div>

<div class="matches" id="searchResults" style="display: none;"></div>

<script>
function toggleFavorite(matchId, element) {
    const wasActive = element.classList.contains("active");
    if (wasActive) {
        element.classList.remove("active");
        element.style.backgroundImage = "url('Images/bookmark.png')";
    } else {
        element.classList.add("active");
        element.style.backgroundImage = "url('Images/bookmark-white.png')";
    }

    fetch("toggle_favorite.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `match_id=${matchId}`
    })
    .then(res => res.text())
    .then(response => {
        console.log(" Server Response:", response.trim());
    })
    .catch(err => {
        console.error(" Error:", err);
        if (wasActive) {
            element.classList.add("active");
            element.style.backgroundImage = "url('Images/bookmark-white.png')";
        } else {
            element.classList.remove("active");
            element.style.backgroundImage = "url('Images/bookmark.png')";
        }
    });
}



document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".bookmark").forEach(function (el) {
        el.addEventListener("click", function () {
            const matchId = this.getAttribute("data-id");
            toggleFavorite(matchId, this);
        });
    });
});

function goToMatch(id) {
    const url = `match2.php?id=${id}`;
    window.location.href = url;
}


    function performSearch() {
        const query = searchInput.value.trim();

        if (query === "") {
            group1.style.display = "flex";
            group2.style.display = "flex";
            group1Title.style.display = "block";
            group2Title.style.display = "block";
            searchResults.style.display = "none";
            searchResults.innerHTML = "";
            return;
        }

        fetch(`match1.php?query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                group1.style.display = "none";
                group2.style.display = "none";
                group1Title.style.display = "none";
                group2Title.style.display = "none";

                searchResults.style.display = "flex";
                searchResults.innerHTML = "";

                if (data.length === 0) {
                    const emptyCard = document.createElement("div");
                    emptyCard.className = "match-card";
                    emptyCard.innerHTML = `
                        <p style="font-weight: bold; font-size: 18px;">لا توجد مباريات مطابقة</p>
                        <p style="font-size: 15px; opacity: 0.8;">تحقق من اسم الفريق أو جرّب كلمة أخرى</p>
                    `;
                    searchResults.appendChild(emptyCard);
                    return;
                }

                data.forEach(match => {
                    const card = document.createElement("div");
                    card.className = "match-card";
                    card.innerHTML = `
                        <div class="bookmark ${match.is_favorite ? 'active' : ''}" data-id="${match.MATCH_ID}"></div>
                        <img src="Images/${match.MATCH_IMAGE}" alt="${match.TEAM1} vs ${match.TEAM2}">
                        <p>${match.TEAM1} × ${match.TEAM2}</p>
                        <p>${match.MATCH_DATE} | ${match.VENUE}</p>
                        <button onclick="goToMatch('${match.MATCH_ID}', '${match.TEAM1}', '${match.TEAM2}', '${match.MATCH_IMAGE}')">احجز الآن</button>
                    `;
                    searchResults.appendChild(card);
                });

                document.querySelectorAll("#searchResults .bookmark").forEach(function (el) {
                    el.addEventListener("click", function () {
                        const matchId = this.getAttribute("data-id");
                        toggleFavorite(matchId, this);
                    });
                });
            });
    }

    const searchInput = document.getElementById("searchInput");
    const searchIcon = document.querySelector(".search-container img");
    const searchResults = document.getElementById("searchResults");

    const group1 = document.getElementById("group1");
    const group2 = document.getElementById("group2");
    const group1Title = document.getElementById("group1Title");
    const group2Title = document.getElementById("group2Title");

    searchIcon.addEventListener("click", performSearch);
    searchInput.addEventListener("input", performSearch);
    searchInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            performSearch();
        }
    });

  
</script>



    <br> <br><br>

    <footer class="footer">
        <div class="footer-section footer-logo">
            <img src="Images/logo1.png" alt="Hayyakm 2034">
        </div>
        <div class="footer-section">Contact</div>
        <div class="footer-section">Hayyakm2034@gmail.com</div>
        <div class="footer-section">Services</div>
            <div class="footer-section social-icon">
                <img src="Images/WhatsApp.png" alt="WhatsApp" class="social-link">
                <img src="Images/Tiktok.png" alt="Tiktok" class="social-link">
                <img src="Images/x.png" alt="Snapchat" class="social-link">
                <img src="Images/facebook.png" alt="Instagram" class="social-link">
            </div>
        </div>
        <div class="footer-section">©Hayyakm2034</div>
    </footer>
    
</body>
</html>