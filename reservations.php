<?php
session_start();
require 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Cancel restaurant reservation
if (isset($_GET['cancel_restaurant'])) {
    $res_id = intval($_GET['cancel_restaurant']);
    mysqli_query($conn, "DELETE FROM restaurant_reservations WHERE reservation_id = $res_id AND user_id = $user_id");
    header("Location: reservations.php");
    exit();
}

// Cancel hotel reservation
if (isset($_GET['cancel_hotel'])) {
    $res_id = intval($_GET['cancel_hotel']);
    mysqli_query($conn, "DELETE FROM hotel_reservations WHERE reservation_id = $res_id AND user_id = $user_id");
    header("Location: reservations.php");
    exit();
}

// Fetch restaurant reservations
$restaurant_sql = "SELECT rr.reservation_id, r.name, rr.date, rr.time, rr.guests, rr.payment_status
                   FROM restaurant_reservations rr 
                   JOIN restaurants r ON rr.restaurant_id = r.restaurant_id 
                   WHERE rr.user_id = $user_id 
                   ORDER BY rr.date DESC, rr.time DESC";
$restaurant_result = mysqli_query($conn, $restaurant_sql);

// Fetch hotel reservations
$hotel_sql = "SELECT hr.reservation_id, h.name, hr.checkin_date, hr.checkout_date, hr.rooms, hr.payment_status
              FROM hotel_reservations hr 
              JOIN hotels h ON hr.hotel_id = h.hotel_id 
              WHERE hr.user_id = $user_id 
              ORDER BY hr.checkin_date DESC";

$hotel_result = mysqli_query($conn, $hotel_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserve'])) {
    // Assuming reservation data already inserted and $reservation_id is available
    $payment_method = $_POST['payment_method'];
    $amount = $_POST['amount'];
    $status = ($payment_method == 'cash') ? 'Not Paid' : 'Paid';

    $insert_payment = "INSERT INTO restaurant_payments (reservation_id, amount, method, status)
                       VALUES ('$reservation_id', '$amount', '$payment_method', '$status')";
    mysqli_query($conn, $insert_payment);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Reservations</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #eaf0f6;
        }

        header {
            background-color: #142850;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(20, 40, 80, 0.15);
        }

        h2 {
            color: #142850;
            margin-bottom: 15px;
        }

        .res-box {
            background-color: #f1f6fb;
            border-left: 5px solid #27496d;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            position: relative;
        }

        .res-box strong {
            color: #27496d;
        }

        .cancel-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #c0392b;
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .cancel-btn:hover {
            background: #e74c3c;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #142850;
            color: white;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>
    </header>

    <div class="container">
        <h2>🍽️ Restaurant Reservations</h2>
        <?php if (mysqli_num_rows($restaurant_result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($restaurant_result)): ?>
                <div class="res-box">
                    <strong>Restaurant:</strong> <?php echo htmlspecialchars($row['name']); ?><br>
                    <strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?><br>
                    <strong>Time:</strong> <?php echo htmlspecialchars($row['time']); ?><br>
                    <strong>People:</strong> <?php echo htmlspecialchars($row['guests']); ?><br>
                    <strong>Payment:</strong> 
                    <span class="<?php echo ($row['payment_status'] == 'Paid') ? 'paid' : 'not-paid'; ?>">
    <?php echo htmlspecialchars($row['payment_status']); ?>
</span>


                    <a class="cancel-btn" href="?cancel_restaurant=<?php echo $row['reservation_id']; ?>">Cancel</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No restaurant reservations yet.</p>
        <?php endif; ?>

        <h2>🏨 Hotel Reservations</h2>
        <?php if (mysqli_num_rows($hotel_result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($hotel_result)): ?>
                <div class="res-box">
                    <strong>Hotel:</strong> <?php echo htmlspecialchars($row['name']); ?><br>
                    <strong>Check-in:</strong> <?php echo htmlspecialchars($row['checkin_date']); ?><br>
                    <strong>Check-out:</strong> <?php echo htmlspecialchars($row['checkout_date']); ?><br>
                    <strong>Rooms:</strong> <?php echo htmlspecialchars($row['rooms']); ?><br>
                    <strong>Payment:</strong> 
<span class="<?php echo ($row['payment_status'] == 'Paid') ? 'paid' : 'not-paid'; ?>">
    <?php echo htmlspecialchars($row['payment_status']); ?>
</span>

                    <a class="cancel-btn" href="?cancel_hotel=<?php echo $row['reservation_id']; ?>">Cancel</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hotel reservations yet.</p>
        <?php endif; ?>
    </div>

    <footer>
        &copy; <?php echo date('Y'); ?> Mumbai Tourism Project
    </footer>
</body>
</html>
