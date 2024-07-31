<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

include("../config/config.php");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        header("Location: Users.php");
        exit;
    } catch (PDOException $e) {
        die("Could not delete user: " . $e->getMessage());
    }
}
?>
