<?php
session_start();

// Redirect to login if not logged in (optional)
if (!isset($_SESSION['username'])) {
    $username = "Guest";
} else {
    $username = $_SESSION['username'];
}

// ✅ DB Connection
require 'conn.php';

// ✅ Sort Logic
$order = "ASC";
if (isset($_GET['sort']) && $_GET['sort'] == "desc") {
    $order = "DESC";
}
$query = "SELECT spot_id, name, rating FROM spots ORDER BY rating $order";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Sightseeing Spots in Mumbai</title>
    <link rel="stylesheet" href="sights.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
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

    .navbar-links li {
    position: relative;
    }

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

    .dropdown a:hover {
        background-color: #EAEAEA;
        color: white;
    }

    /* Dropdown menu */
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
        color: black
    }

    /* Show dropdown on hover */
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
        <h1>Top Sightseeing Spots in Mumbai</h1>
        <nav>
            <ul class="navbar-links">
                <li><a href="home.php">Home</a></li>
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
    <div class="sort-btns">
            <a href="?sort=asc">Sort by Rating: Low to High</a>
            <a href="?sort=desc">Sort by Rating: High to Low</a>
    </div>
        
    <section class="sightseeing-container">
            <div class="sight-card">
                <div class="image-placeholder" style="background-image: url(imgs/goi.webp); background-size: cover;"></div>
                <div class="sight-card-content">
                    <h3>Gateway of India</h3>
                    <p>A historic monument and one of Mumbai’s most iconic landmarks.</p>
                    <div class="rating">⭐ 4.7 <span>(1200 ratings)</span></div>
                </div>
            </div>
            
            <div class="sight-card">
                <div class="image-placeholder" style="background-image: url(imgs/marine.jpeg); background-size: cover;"></div>
                <div class="sight-card-content">
                    <h3>Marine Drive</h3>
                    <p>A beautiful promenade along the coast, perfect for sunsets.</p>
                    <div class="rating">⭐ 4.6 <span>(950 ratings)</span></div>
                </div>
            </div>
            
            <div class="sight-card">
                <div class="image-placeholder" style="background-image: url(imgs/caves.webp); background-size: cover;"></div>
                <div class="sight-card-content">
                    <h3>Elephanta Caves</h3>
                    <p>Ancient rock-cut caves with stunning carvings and history.</p>
                    <div class="rating">⭐ 4.5 <span>(780 ratings)</span></div>
                </div>
            </div>
            
            <div class="sight-card">
                <div class="image-placeholder" style="background-image: url(imgs/pow.jpg); background-size: cover;"></div>
                <div class="sight-card-content">
                    <h3>Prince of Wales Museum</h3>
                    <p>A historic museum showcasing Mumbai’s art, culture, and heritage.</p>
                    <div class="rating">⭐ 4.4 <span>(860 ratings)</span></div>
                </div>
            </div>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2025 Explore Mumbai</p>
    </footer>
</body>
</html>
