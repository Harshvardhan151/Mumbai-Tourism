<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Mumbai | Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var mumbai = { lat: 19.0760, lng: 72.8777 };
            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: mumbai
            });
            var marker = new google.maps.Marker({
                position: mumbai,
                map: map
            });
        }
    </script>
<style>
        .navbar-links {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 0;
            margin: 0;
            background: #142850;
        }
        .navbar-links li { position: relative; }
        .navbar-links a, .dropbtn {
            display: inline-block;
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background: #142850;
            min-width: 180px;
            z-index: 1;
            right: 0;
            border-radius: 4px;
            overflow: hidden;
        }
        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-family: arial;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
            color: black;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .sort-btns {
            text-align: center;
            margin-bottom: 20px;
        }
        .sort-btns a {
            padding: 10px 20px;
            background: #142850;
            color: white;
            text-decoration: none;
            margin: 0 10px;
            border-radius: 5px;
        }
        .sort-btns a:hover {
            background-color: #27496d;
        }
</style>
</head>
<body>
    <header>
        <h1>Welcome to Mumbai</h1>
        <p>The City of Dreams – A blend of heritage, culture, and modernity</p>
        <nav>
    <ul class="navbar-links">
        <li><a href="spots.php">Sightseeing</a></li>
        <li><a href="restaurants.php">Local Eateries</a></li>
        <li><a href="hotels.php">Stay in Comfort</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        
        <!-- Username dropdown -->
        <li class="dropdown">
            <button class="dropbtn"><i class="fa-solid fa-circle-user"></i>&nbsp;&nbsp;<?php echo $_SESSION['username']; ?></button>
            <div class="dropdown-content">
                <a href="reservations.php">Your Reservations</a>
                <a href="logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>
    </header>
    <main>
        <section id="slideshow">
            <div class="slideshow-container">
                <img class="slide" src="imgs/ss3.jpg" alt="Mumbai Image">
                <img class="slide" src="imgs/cuh.avif" alt="Mumbai Image">
                <img class="slide" src="imgs/trimg.jpg" alt="Mumbai Image">
            </div>
        </section>
        <section id="intro">
            <h2>Discover Mumbai</h2>
            <div class="image-placeholder1">
                <img src="imgs/hp.webp"> 
            </div>
            <div class="homeinfo" style="padding-left: 150px; padding-right: 150px;">
            <p >Mumbai is more than just a city—it’s an emotion, a rhythm that never slows down. As India’s financial powerhouse, it beats with ambition, dreams, and an undying spirit. From the colonial-era charm of South Mumbai to the high-rise marvels of Bandra, every street tells a story. Iconic landmarks like the Gateway of India, Chhatrapati Shivaji Terminus, and the endless Arabian Sea coastline add to its allure. The city welcomes you with open arms, whether you come for its culture, its food, or just to chase your dreams.</p>
        </div>
        </section>
        <section id="history">
            <h2>History & Heritage</h2>
            <div class="image-placeholder2">
                <img src="imgs/idk.jpg" height="350px">
            </div>
            <div class="homeinfo" style="padding-left: 150px; padding-right: 150px;">
            <p>Once a collection of seven islands, Mumbai’s transformation into a global metropolis is nothing short of extraordinary. The city’s colonial past is etched into its grand Victorian buildings, timeless forts, and old-world alleys. The majestic Chhatrapati Shivaji Maharaj Terminus stands as a testament to the British Raj’s architectural grandeur. The historic Elephanta Caves, a UNESCO World Heritage Site, whisper tales from ancient times. Every fort, temple, and museum here echoes the resilience and evolution of a city that has witnessed empires rise and fall.</p>
        </div>
        </section>
        <section id="culture">
            <h2>Culture & Lifestyle</h2>
            <div>
                <img src="imgs/ganpati.jpg" height="350px">
            </div>
            <div class="homeinfo" style="padding-left: 150px; padding-right: 150px;"    >
            <p>Mumbai’s culture is an intoxicating blend of the old and the new, where centuries-old traditions meet modern-day aspirations. As the birthplace of Bollywood, the city thrives on cinematic dreams and artistic expression. The streets are a canvas for vibrant festivals, from the electrifying Ganesh Chaturthi celebrations to the serene beauty of Diwali lights. From the bustling bazaars of Colaba to the refined elegance of Prithvi Theatre, every corner is steeped in history, art, and an unbreakable passion for life.</p>
        </div>
        </section>
        <section id="explore">
            <h2>Explore More</h2>
            <div class="explore-links">
                <a href="spots.php" id="b1">Top Sightseeing Spots</a>
                <a href="restaurants.php" id="b2">Best Local Eateries</a>
                <a href="hotels.php" id="b3">Hotels for Every Budget</a>
            </div>
        </section>
        <section id="map-section">
            <h2>Find Mumbai on the Map</h2>
            <div id="map">
                <iframe src="https://www.google.com/maps/embed?..." width="100%" height="300" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Explore Mumbai | Designed for Mumbai Tourism Promotion</p>               
    </footer>
    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll(".slide");

        function showSlide() {
            slides.forEach((slide, index) => {
                slide.classList.remove("active");
                if (index === currentIndex) slide.classList.add("active");
            });
            currentIndex = (currentIndex + 1) % slides.length;
        }

        setInterval(showSlide, 3000);
        showSlide();
    </script>
</body>
</html>
