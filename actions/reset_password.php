<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /pages/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
$stmt->execute([$password, $user_id]);

header('Location: /pages/dashboard.php');
?>
