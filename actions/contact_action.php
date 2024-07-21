<?php
session_start();
require '../config/config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$stmt = $pdo->prepare('INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)');
$stmt->execute([$name, $email, $message]);

header('Location: /pages/contact.php?success=1');
?>
