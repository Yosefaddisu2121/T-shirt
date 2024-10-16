<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

echo "Welcome, " . $_SESSION['username'];
?>
