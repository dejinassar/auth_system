<?php
session_start();
require '../config/config.php';

function validate_name($name) {
    if (strlen($name) <= 2) {
        return "Name should be more than 2 characters.";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        return "Name should contain only alphabets.";
    }
    return "";
}

function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    return "";
}

$errors = [];
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$errors['name_error'] = validate_name($name);
$errors['email_error'] = validate_email($email);
if (empty($message)) {
    $errors['message_error'] = "Message cannot be empty.";
}

$errors = array_filter($errors); // Remove empty error messages

if (!empty($errors)) {
    // Redirect back with errors
    $query = http_build_query($errors);
    header("Location: /pages/contact.php?" . $query);
    exit;
} else {
    // Insert data into the database
    $stmt = $pdo->prepare('INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)');
    $stmt->execute([$name, $email, $message]);

    // Redirect with success message
    header('Location: /pages/contact.php?success=1');
    exit;
}
?>
