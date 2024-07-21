<?php
session_start();
require '../config/config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prepare the SQL statement to fetch the user
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            header('Location: /pages/dashboard.php');
            exit();
        } else {
            // Invalid email or password
            echo 'Invalid email or password.';
        }
    } catch (PDOException $e) {
        // Handle potential errors
        echo 'Database error: ' . $e->getMessage();
    }
} else {
    // If the form is not submitted via POST, show an error message
    echo 'Invalid request method.';
}
?>
