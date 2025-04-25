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
$query = "SELECT hotel_id, name, price FROM hotels ORDER BY price $order";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Mumbai - Stays</title>
    <link rel="stylesheet" href="hotels.css">
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
        <h1>Best Stays in Mumbai</h1>
        <nav>
            <ul class="navbar-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="spots.php">Sightseeing</a></li>
                <li><a href="restaurants.php">Local Eateries</a></li>
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
        <section id="stays">
            <div class="sort-btns">
            <a href="?sort=asc">Sort by Price: Low to High</a>
            <a href="?sort=desc">Sort by Price: High to Low</a>
        </div>
        <div class="sightseeing-container">
        <?php
        $hotel_data = [
            "The Taj Mahal Palace" => [
                "image" => "imgs/taj.jpg",
                "description" => "A luxurious 5-star hotel offering world-class service and stunning sea views.",
                "rating" => "4.8",
                "reviews" => "5,000"
            ],
            "ITC Maratha" => [
                "image" => "imgs/itc.png",
                "description" => "An elegant hotel near the airport, known for its grand decor and top-notch hospitality.",
                "rating" => "4.6",
                "reviews" => "3,200"
            ],
            "Trident, Nariman Point" => [
                "image" => "imgs/trident.avif",
                "description" => "Luxury stay with a mesmerizing view of Marine Drive and excellent service.",
                "rating" => "4.7",
                "reviews" => "4,500"
            ],
            "Abode Bombay" => [
                "image" => "imgs/abode.jpg",
                "description" => "A stylish boutique hotel in the heart of Colaba, offering a cozy and artsy experience.",
                "rating" => "4.5",
                "reviews" => "2,800"
            ]
        ];
        
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            if (!isset($hotel_data[$name])) continue;

            $data = $hotel_data[$name];
        ?>
            <a href="hotel-details.php?id=<?php echo $row['hotel_id']; ?>" class="sight-card" style="text-decoration: none; color:white;">
                <div class="image-placeholder" style="background-image: url('<?php echo $data['image']; ?>'); background-size: cover; background-position: center;"></div>
                <div class="sight-card-content">
                    <h3><?php echo htmlspecialchars($name); ?></h3>
                    <p><?php echo $data['description']; ?></p>
                    <div class="rating">⭐ <?php echo $data['rating']; ?> <span>(<?php echo $data['reviews']; ?> reviews)</span></div>
                    <p>Avg. Cost: ₹<?php echo $row['price']; ?> per person</p>
                </div>
            </a>
        <?php
        }
        ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Explore Mumbai</p>
    </footer>
</body>
</html>
