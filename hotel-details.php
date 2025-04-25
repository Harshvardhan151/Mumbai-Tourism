<?php
session_start();
require 'conn.php';

$hotel_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$username = $_SESSION['username'] ?? "Guest";
$user_id = $_SESSION['user_id'] ?? null;

// Fetch restaurant info
$hotel_sql = "SELECT * FROM hotels WHERE hotel_id = $hotel_id";
$hotel_result = mysqli_query($conn, $hotel_sql);
$hotel = mysqli_fetch_assoc($hotel_result);

// Static data for desc/images/ratings
$static_data = [
    "The Taj Mahal Palace" => [
        "image" => "imgs/taj.jpg",
        "desc" => "A luxurious 5-star hotel offering world-class service and stunning sea views.",
        "price" => 15000.00
        
    ],
    "ITC Maratha" => [
        "image" => "imgs/itc.png",
        "desc" => "An elegant hotel near the airport, known for its grand decor and top-notch hospitality.",
        "price" => 10000.00
    ],
    "Trident, Nariman Point" => [
        "image" => "imgs/trident.avif",
        "desc" => "Luxury stay with a mesmerizing view of Marine Drive and excellent service.",
        "price" => 12000.00
    ],
    "Abode Bombay" => [
        "image" => "imgs/abode.jpg",
        "desc" => "A stylish boutique hotel in the heart of Colaba, offering a cozy and artsy experience.",
        "price" => 8000.00
    ]
];

// Handle review form

$already_reviewed = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_id) {
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $check_sql = "SELECT * FROM hotel_reviews WHERE user_id = $user_id AND hotel_id = $hotel_id";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) == 0) {
        $insert_sql = "INSERT INTO hotel_reviews (user_id, hotel_id, rating, comment)
                       VALUES ($user_id, $hotel_id, $rating, '$comment')";
        mysqli_query($conn, $insert_sql);
    } else {
        $already_reviewed = true;
    }
}

// User review (if exists)
$user_review = null;
if ($user_id) {
    $ur_sql = "SELECT rating, comment FROM hotel_reviews WHERE user_id = $user_id AND hotel_id = $hotel_id";
    $ur_result = mysqli_query($conn, $ur_sql);
    $user_review = mysqli_fetch_assoc($ur_result);
}

/*
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review']) && $user_id) {
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // Check if user already reviewed, then insert if not
    $check_sql = "SELECT * FROM hotel_reviews WHERE user_id=$user_id AND hotel_id=$hotel_id";
    $result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($result) === 0) {
        $insert_review_sql = "INSERT INTO hotel_reviews (user_id, hotel_id, rating, comment) 
                              VALUES ($user_id, $hotel_id, $rating, '$comment')";
        mysqli_query($conn, $insert_review_sql);
    } else {
        $already_reviewed = true;
    }
}
*/
// Avg rating
$avg_sql = "SELECT AVG(rating) AS avg_rating FROM hotel_reviews WHERE hotel_id = $hotel_id";
$avg_result = mysqli_query($conn, $avg_sql);
$avg_rating = round(mysqli_fetch_assoc($avg_result)['avg_rating'], 1);

// Reservation form handling
$reservation_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserve']) && $user_id) {
    $name = mysqli_real_escape_string($conn, $_POST['res_name']);
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $rooms = (int)$_POST['rooms'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $card_number = $_POST['card_number'] ?? '';
    $expiry_date = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    $upi_ref = $_POST['upi_ref'] ?? '';

    $insert_res_sql = "INSERT INTO hotel_reservations (user_id, hotel_id, name, checkin_date, checkout_date, rooms, amount, payment_method)
                       VALUES ($user_id, $hotel_id, '$name', '$checkin_date', '$checkout_date', $rooms, '$amount', '$payment_method')";

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
    <title><?php echo htmlspecialchars($hotel['name']); ?> - Details</title>
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
        <div class="image" style="background-image: url('<?php echo $static_data[$hotel['name']]['image']; ?>'); "></div>
        <h1><?php echo htmlspecialchars($hotel['name']); ?></h1>
        <p class="price"><strong>Avg. Cost:</strong> ₹<?php echo htmlspecialchars($hotel['price']); ?> per person</p>
        <p><?php echo $static_data[$hotel['name']]['desc']; ?></p>
        <p class="avg-rating"><strong>Average Rating:</strong> <?php echo $avg_rating ? "⭐ $avg_rating / 5" : "No reviews yet"; ?></p>
        <?php if ($user_id): ?>
<div class="reservation-form">
    <h3>Make a Reservation</h3>
    <?php if ($reservation_msg): ?>
        <p style="color: green;"><strong><?php echo $reservation_msg; ?></strong></p>
    <?php endif; ?>

    <!-- php to fetch amt from backend -->

        <?php
    $hotel_name = $hotel['name'];
    $price = $hotel['price']; // fetched from static data
    ?>

    <!-- Reservation Form -->
<form method="POST" action="">
    <input type="hidden" name="hotel_id" value="<?php echo $hotel['hotel_id']; ?>">
    <label for="name">Name:</label>
    <input type="text" name="res_name" required><br>

    <label for="people">Number of People:</label>
    <input type="number" name="people" min="1" required><br>

    <label for="checkin_date">Check-in Date:</label>
    <input type="date" name="checkin_date" min="<?php echo date('Y-m-d'); ?>" required><br>

    <label for="checkout_date">Check-out Date:</label>
    <input type="date" name="checkout_date" min="<?php echo date('Y-m-d'); ?>" required><br>

    <label for="rooms">Number of Rooms:</label>
    <input type="number" name="rooms" id="rooms" min="1" value="1" required oninput="calculateAmount()"><br>

    <label for="amount">Amount (₹):</label>
    <input type="number" name="amount" id="amount" value="<?php echo $price; ?>" readonly required><br>



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

    <input type="submit" name="reserve" value="Reserve">
</form>

<script>
    function calculateAmount() {
        let rooms = document.getElementById('rooms').value;
        let pricePerRoom = <?php echo $price; ?>;
        let total = rooms * pricePerRoom;
        document.getElementById('amount').value = total;
    }

    function showPayment(method) {
        document.getElementById('card_form').style.display = (method === 'card') ? 'block' : 'none';
        document.getElementById('upi_form').style.display = (method === 'upi') ? 'block' : 'none';
        document.getElementById('cash_note').style.display = (method === 'cash') ? 'block' : 'none';
    }
</script>


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
$reviewQuery = "SELECT users.username, hotel_reviews.rating, hotel_reviews.comment 
                FROM hotel_reviews 
                JOIN users ON hotel_reviews.user_id = users.user_id 
                WHERE hotel_reviews.hotel_id = $hotel_id";
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

