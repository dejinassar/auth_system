<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /pages/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$profile_picture = $_FILES['profile_picture']['name'];

if ($profile_picture) {
    $target_dir = "../assets/images/profile_pictures/";
    $target_file = $target_dir . basename($profile_picture);
    move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
} else {
    $stmt = $pdo->prepare('SELECT profile_picture FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $profile_picture = $user['profile_picture'];
}

$stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, profile_picture = ? WHERE id = ?');
$stmt->execute([$firstname, $lastname, $profile_picture, $user_id]);

$_SESSION['firstname'] = $firstname;
$_SESSION['lastname'] = $lastname;

header('Location: /pages/dashboard.php');
?>
