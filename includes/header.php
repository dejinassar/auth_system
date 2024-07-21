<?php
session_start();
require '../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth System</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="/pages/home.php">Home</a></li>
            <li><a href="/pages/about.php">About</a></li>
            <li><a href="/pages/contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/pages/dashboard.php"><?php echo htmlspecialchars($_SESSION['firstname']) . ' ' . htmlspecialchars($_SESSION['lastname']); ?></a></li>
                <li><a href="/actions/logout_action.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/pages/login.php">Login</a></li>
                <li><a href="/pages/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <main>
