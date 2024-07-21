<?php
session_start();
require '../config/config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and validate form inputs
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    // Validate required fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        die("Please fill in all required fields.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement
    try {
        $stmt = $pdo->prepare('INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)');
        $stmt->execute([$firstname, $lastname, $email, $hashed_password]);

        // Redirect to the login page upon successful registration
        header('Location: /pages/login.php');
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Invalid request method.");
}
?>
