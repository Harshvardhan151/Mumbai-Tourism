<?php
session_start();
require_once 'db.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    try {
        $stmt = $pdo->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        $success = true;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Explore Mumbai</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="contact.css">
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
        .dropdown a:hover { background-color: #EAEAEA; color: white; }
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
        .dropdown-content a:hover { background-color: #ddd; color: black; }
        .dropdown:hover .dropdown-content { display: block; }
        .sort-btns { text-align: center; margin-bottom: 20px; }
        .sort-btns a {
            padding: 10px 20px;
            background: #142850;
            color: white;
            text-decoration: none;
            margin: 0 10px;
            border-radius: 5px;
        }
        .sort-btns a:hover { background-color: #27496d; }
        .success-msg { color: green; margin-top: 10px; font-weight: bold; }
        .error-msg { color: red; margin-top: 10px; font-weight: bold; }
    </style>
</head>

<body>
    <header>
        <div id="title">
            <h1>Contact Us</h1>
        </div>
        <nav>
            <ul class="navbar-links">
                <li><a href="spots.php">Sightseeing</a></li>
                <li><a href="restaurants.php">Local Eateries</a></li>
                <li><a href="hotels.php">Stay in Comfort</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li class="dropdown">
                    <button class="dropbtn"><i class="fa-solid fa-circle-user"></i>&nbsp;&nbsp;<?php echo $_SESSION['username'] ?? 'Guest'; ?></button>
                    <div class="dropdown-content">
                        <a href="reservations.php">Your Reservations</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="contact-info">
            <h2>Get in Touch</h2>
            <p>For inquiries, suggestions, or collaborations, reach out to us using the form below or through our social media channels.</p>

            <form id="contact-form" method="POST" action="">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="1" required></textarea>

                <button type="submit">Send Message</button>
                <?php if (isset($success) && $success): ?>
                    <div class="success-msg">Message sent successfully!</div>
                <?php elseif (isset($error)): ?>
                    <div class="error-msg"><?php echo $error; ?></div>
                <?php endif; ?>
            </form>
        </section>

        <section id="socials">
            <h2>Follow Us</h2>
            <p>Stay updated with our latest updates and travel guides.</p>
            <a href="#" class="c"><i class="fa-brands fa-instagram"></i> Instagram</a> |
            <a href="#" class="c"><i class="fa-brands fa-twitter"></i> Twitter</a> |
            <a href="#" class="c"><i class="fa-brands fa-facebook"></i> Facebook</a>
        </section>

        <section id="map">
            <h2>Find Us</h2>
            <iframe src="https://www.google.com/maps/embed?..." width="100%" height="300" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Explore Mumbai | Designed for Mumbai Tourism Promotion</p>
    </footer>
</body>
</html>
