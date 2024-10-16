<?php
// Database connection
$servername = "localhost";  // Your server name (adjust if necessary)
$username = "root";         // Your database username
$password = "";             // Your database password
$dbname = "yosifirst";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $checkUser = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($checkUser);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username is already taken
        echo "Username already exists. Please choose a different one.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user data into the database
        $insertUser = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($insertUser);
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            header("Location: ffal.html");
            // Optionally, redirect to the login page or another page
            // header("Location: login.html");
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}

$conn->close();
?>
