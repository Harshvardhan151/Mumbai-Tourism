<?php
session_start();
require 'conn.php';

$restaurant_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$username = $_SESSION['username'] ?? "Guest";
$user_id = $_SESSION['user_id'] ?? null;

// Fetch restaurant info
$restaurant_sql = "SELECT * FROM restaurants WHERE restaurant_id = $restaurant_id";
$restaurant_result = mysqli_query($conn, $restaurant_sql);
$restaurant = mysqli_fetch_assoc($restaurant_result);

// Static data for desc/images/ratings
$static_data = [
    "Leopold Cafe" => [
        "image" => "imgs/leopold.jpg",
        "desc" => "A legendary cafe known for its vibrant atmosphere and delicious food.",
        "price" => 800
    ],
    "Bademiya" => [
        "image" => "imgs/bademiya.webp",
        "desc" => "Famous for its late-night kebabs and street food experience.",
        "price" => 500
    ],
    "Britannia & Co." => [
        "image" => "imgs/brc.jpg",
        "desc" => "Known for its authentic Parsi cuisine, including the famous Berry Pulao.",
        "price" => 700
    ],
    "Kyani & Co." => [
        "image" => "imgs/kyc.jpg",
        "desc" => "One of Mumbai’s oldest Irani cafes, serving classic bun maska and chai.",
        "price" => 300
    ]
];

// Handle review form
$already_reviewed = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_id) {
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $check_sql = "SELECT * FROM restaurant_reviews WHERE user_id = $user_id AND restaurant_id = $restaurant_id";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) == 0) {
        $insert_sql = "INSERT INTO restaurant_reviews (user_id, restaurant_id, rating, comment)
                       VALUES ($user_id, $restaurant_id, $rating, '$comment')";
        mysqli_query($conn, $insert_sql);
    } else {
        $already_reviewed = true;
    }
}

// Avg rating
$avg_sql = "SELECT AVG(rating) AS avg_rating FROM restaurant_reviews WHERE restaurant_id = $restaurant_id";
$avg_result = mysqli_query($conn, $avg_sql);
$avg_rating = round(mysqli_fetch_assoc($avg_result)['avg_rating'], 1);

// User review (if exists)
$user_review = null;
if ($user_id) {
    $ur_sql = "SELECT rating, comment FROM restaurant_reviews WHERE user_id = $user_id AND restaurant_id = $restaurant_id";
    $ur_result = mysqli_query($conn, $ur_sql);
    $user_review = mysqli_fetch_assoc($ur_result);
}
// Reservation form handling
$reservation_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserve']) && $user_id) {
    $name = mysqli_real_escape_string($conn, $_POST['res_name']);
    $date = $_POST['res_date'];
    $time = $_POST['res_time'];
    $guests = (int)$_POST['res_guests'];

    $insert_res_sql = "INSERT INTO restaurant_reservations (user_id, restaurant_id, name, date, time, guests)
                       VALUES ($user_id, $restaurant_id, '$name', '$date', '$time', $guests)";
    if (mysqli_query($conn, $insert_res_sql)) {
        $reservation_msg = "Reservation successful!";
    } else {
        $reservation_msg = "Something went wrong. Try again.";
    }
}



?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($restaurant['name']); ?> - Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    body {
        margin: 0;
        background-color: #eaf0f6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #1b1b1b;
    }

    header {
        background-color: #142850;
        color: white;
        padding: 20px 0;
        text-align: center;
    }

    h1, h2, h3 {
        color: #142850;
    }

    .container,
    .restaurant-details-container {
        max-width: 1000px;
        margin: 40px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(20, 40, 80, 0.15);
    }

    .restaurant-images {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        margin-bottom: 20px;
    }

    .restaurant-images img {
        height: 250px;
        border-radius: 10px;
        object-fit: cover;
    }

    .restaurant-info {
        margin-bottom: 20px;
    }

    .price,
    .avg-rating,
    .rating {
        font-size: 18px;
        margin: 10px 0;
        color: #00a8cc;
    }

    .reservation-form,
    .review-form {
        margin-top: 30px;
        background-color: #f1f6fb;
        padding: 20px;
        border-radius: 12px;
    }

    .reservation-form h3,
    .review-form h3 {
        margin-top: 0;
        color: #27496d;
    }

    form {
        margin-top: 20px;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 15px;
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
    }

    input[type="submit"],
    button {
        background-color: #27496d;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
        font-weight: bold;
    }

    input[type="submit"]:hover,
    button:hover {
        background-color: #0c1b33;
    }

    .rating-stars {
        display: flex;
        gap: 6px;
        margin-top: 10px;
    }

    .rating-stars i {
        font-size: 24px;
        color: #ccc;
        cursor: pointer;
    }

    .rating-stars input {
        display: none;
    }

    .rating-stars i.checked {
        color: #f4c542;
    }

    .existing-reviews {
        margin-top: 40px;
    }

    .review-box {
        background: #dde9f4;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 5px solid #27496d;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: #142850;
        color: white;
        margin-top: 50px;
    }
    .image {
    width: 100%;
    height: 300px;
    background-size: cover;
    background-position: center;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

</style>

</head>


<body>
    <div class="container">
        <div class="image" style="background-image: url('<?php echo $static_data[$restaurant['name']]['image']; ?>'); "></div>
        <h1><?php echo htmlspecialchars($restaurant['name']); ?></h1>
        <p class="price"><strong>Avg. Cost:</strong> ₹<?php echo htmlspecialchars($restaurant['price']); ?> per person</p>
        <p><?php echo $static_data[$restaurant['name']]['desc']; ?></p>
        <p class="avg-rating"><strong>Average Rating:</strong> <?php echo $avg_rating ? "⭐ $avg_rating / 5" : "No reviews yet"; ?></p>
        <?php if ($user_id): ?>
<div class="reservation-form">
    <h3>Make a Reservation</h3>
    <?php if ($reservation_msg): ?>
        <p style="color: green;"><strong><?php echo $reservation_msg; ?></strong></p>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="reserve" value="1">
        <label for="res_name">Your Name:</label>
        <input type="text" name="res_name" required>

        <label for="res_date">Date:</label>
        <!--<input type="date" name="res_date" required>-->
        <input type="date" name="res_date" min="<?php echo date('Y-m-d'); ?>" required><br>

        <label for="res_time">Time:</label>
        <input type="time" name="res_time" required>

        <label for="res_guests">No. of Guests:</label>
        <input type="number" name="res_guests" min="1" required>

        <label for="amount">Amount (₹):</label>
    <input type="number" name="amount" id="amount" value=<?php echo htmlspecialchars($restaurant['price']); ?> readonly required><br>


        <label>Payment Method:</label><br>
    <input type="radio" name="payment_method" value="card" onclick="showPayment('card')" required> Card<br>
    <input type="radio" name="payment_method" value="upi" onclick="showPayment('upi')"> UPI<br>
    <input type="radio" name="payment_method" value="cash" onclick="showPayment('cash')"> Cash on Arrival<br><br>


    <div id="card_form" style="display: none;">
        <label>Card Number:</label>
        <input type="text" name="card_number" maxlength="16"><br>
        <label>Expiry Date:</label>
        <input type="month" name="expiry_date"><br>
        <label>CVV:</label>
        <input type="text" name="cvv" maxlength="3"><br>
    </div>

    <div id="upi_form" style="display: none;">
        <label>Scan QR to Pay:</label><br>
        <img src="imgs/dummy_qr.png" alt="UPI QR" style="width:200px;"><br>
        <label>Enter UPI Ref. ID:</label>
        <input type="text" name="upi_ref"><br>
    </div>

    <div id="cash_note" style="display: none;">
        <p><i>Please keep exact change ready at the time of arrival.</i></p>
    </div>

        <br><br>
        <input type="submit" value="Book Reservation">
    </form>
</div>
<?php else: ?>
    <p><em><a href="login.php">Log in</a> to make a reservation.</em></p>
<?php endif; ?>


        <?php if (!$user_id): ?>
            <p><em><a href="login.php">Log in</a> to leave a review.</em></p>
        <?php elseif ($user_review): ?>
            <div class="review-box">
                <h3>Your Review:</h3>
                <p>⭐ <?php echo $user_review['rating']; ?>/5</p>
                <p><?php echo htmlspecialchars($user_review['comment']); ?></p>
            </div>
        <?php else: ?>
            <form method="POST">
                <h3>Leave a Review</h3>
                <label for="rating">Rating:</label>
                <div class="rating-stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label>
                            <input type="radio" name="rating" value="<?php echo $i; ?>" required>
                            <i class="fa fa-star"></i>
                        </label>
                    <?php endfor; ?>
                </div>
                <label for="comment">Comment:</label>
                <textarea name="comment" required></textarea>
                <br><br>
                <button type="submit">Submit Review</button>
                <?php if ($already_reviewed): ?>
                    <p style="color:red;">You've already reviewed this restaurant.</p>
                <?php endif; ?>
            </form>
        <?php endif; ?>
        <?php
$reviewQuery = "SELECT users.username, restaurant_reviews.rating, restaurant_reviews.comment 
                FROM restaurant_reviews 
                JOIN users ON restaurant_reviews.user_id = users.user_id 
                WHERE restaurant_reviews.restaurant_id = $restaurant_id";
$reviewResult = mysqli_query($conn, $reviewQuery);

if (mysqli_num_rows($reviewResult) > 0) {
    echo '<div class="existing-reviews"><h3>Other Reviews</h3>';
    while ($row = mysqli_fetch_assoc($reviewResult)) {
        echo '<div class="review-box">';
        echo '<strong>' . htmlspecialchars($row['username']) . '</strong><br>';
        echo 'Rating: ' . htmlspecialchars($row['rating']) . ' ⭐<br>';
        echo '<p>' . htmlspecialchars($row['comment']) . '</p>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "<p>No reviews yet. Be the first to drop one!</p>";
}
?>

    </div>
    

    <script>
        const stars = document.querySelectorAll('.rating-stars i');
        stars.forEach((star, idx) => {
            star.addEventListener('click', () => {
                stars.forEach((s, i) => {
                    s.classList.toggle('checked', i <= idx);
                });
            });
        });
    </script>
</body>
</html>

<script>
    function showPayment(method) {
        document.getElementById("card_form").style.display = (method === "card") ? "block" : "none";
        document.getElementById("upi_form").style.display = (method === "upi") ? "block" : "none";
        document.getElementById("cash_note").style.display = (method === "cash") ? "block" : "none";
    }

    // block past dates & times
    const dateInput = document.getElementById("res_date");
    const timeInput = document.getElementById("res_time");
    const today = new Date().toISOString().split("T")[0];
    dateInput.setAttribute("min", today);

    dateInput.addEventListener("change", function () {
        const selected = new Date(this.value);
        const now = new Date();

        if (selected.toDateString() === now.toDateString()) {
            timeInput.min = now.toTimeString().slice(0,5);
        } else {
            timeInput.removeAttribute("min");
        }
    });
</script>
