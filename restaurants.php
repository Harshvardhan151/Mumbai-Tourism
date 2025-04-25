<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";

require 'conn.php';

// Sorting Logic
$order = "ASC";
if (isset($_GET['sort']) && $_GET['sort'] == "desc") {
    $order = "DESC";
}
$query = "SELECT restaurant_id, name, price FROM restaurants ORDER BY price $order";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Explore Mumbai - Eateries</title>
    <link rel="stylesheet" href="restaurant.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
        <h1>Best Eateries in Mumbai</h1>
        <nav>
            <ul class="navbar-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="spots.php">Sightseeing</a></li>
                <li><a href="hotels.php">Stay in Comfort</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li class="dropdown">
                    <button class="dropbtn"><i class="fa-solid fa-circle-user"></i>&nbsp;&nbsp;<?php echo htmlspecialchars($username); ?></button>
                    <div class="dropdown-content">
                        <a href="reservations.php">Your Reservations</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Sort Buttons -->
        <div class="sort-btns">
            <a href="?sort=asc">Sort by Price: Low to High</a>
            <a href="?sort=desc">Sort by Price: High to Low</a>
        </div>

        <!-- Restaurant Cards -->
        <div class="sightseeing-container">
        <?php
        $restaurant_data = [
            "Leopold Cafe" => [
                "image" => "imgs/leopold.jpg",
                "description" => "A legendary cafe known for its vibrant atmosphere and delicious food.",
                "rating" => "4.5",
                "reviews" => "2,000"
            ],
            "Bademiya" => [
                "image" => "imgs/bademiya.webp",
                "description" => "Famous for its late-night kebabs and street food experience.",
                "rating" => "4.4",
                "reviews" => "1,500"
            ],
            "Britannia & Co." => [
                "image" => "imgs/brc.jpg",
                "description" => "Known for its authentic Parsi cuisine, including the famous Berry Pulao.",
                "rating" => "4.6",
                "reviews" => "1,800"
            ],
            "Kyani & Co." => [
                "image" => "imgs/kyc.jpg",
                "description" => "One of Mumbai’s oldest Irani cafes, serving classic bun maska and chai.",
                "rating" => "4.3",
                "reviews" => "1,200"
            ]
        ];
        
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            if (!isset($restaurant_data[$name])) continue;

            $data = $restaurant_data[$name];
        ?>
            <a href="restaurant-details.php?id=<?php echo $row['restaurant_id']; ?>" class="sight-card" style="text-decoration: none; color:white;">
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
