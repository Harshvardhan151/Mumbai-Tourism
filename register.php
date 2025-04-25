<?php
$host = "localhost";
$user = "root";
$pass = ""; // Ensure this is correct for your MySQL setup
$db = "mumbaitourism"; // Correct DB name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure hash

    // check if email already registered
    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Email already exists, try login.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            // Successful registration
            echo '<script>
                    alert("Registration successful!");
                  </script>';

            // Meta redirect after alert to the home (after 2 seconds)
            echo '<meta http-equiv="refresh" content="2; url=index.html">'; // Adjust to your home URL
        } else {
            echo "Registration failed: " . $stmt->error;
        }
        $stmt->close();
    }

    $check->close();
}

$conn->close();
?>
