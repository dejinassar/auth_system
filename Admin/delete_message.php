<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

include("../config/config.php");

if (isset($_GET['id'])) {
    $contactId = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([$contactId]);
        header("Location: Messages.php");
        exit;
    } catch (PDOException $e) {
        die("Could not delete message: " . $e->getMessage());
    }
}
?>
