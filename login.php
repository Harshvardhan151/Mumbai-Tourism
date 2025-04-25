<?php
session_start(); // start session at the top

$host = "localhost";
$user = "root";
$pass = ""; // leave empty if no password
$db = "mumbaitourism";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['user_email'] = $email;

            echo '<script>
                    alert("Login successful!");
                    window.location.href = "home.php";
                  </script>';
        } else {
            echo '<script>alert("Incorrect password.");</script>';
        }
    } else {
        echo '<script>alert("Email not registered.");</script>';
    }

    $stmt->close();
}

$conn->close();
?>
