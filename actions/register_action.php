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
    // Validate phone number
// $phone = "123-456-7890";
// if (!preg_match("/^\d{3}-\d{3}-\d{4}$/", $phone)) {
//     echo "Invalid phone number format.";
// }
}

function validate_password($password) {
    if (strlen($password) < 6) {
        return "Password should be at least 6 characters.";
    }
    return "";
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and validate form inputs
    $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
    $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    $errors = [];
    $errors['firstname_error'] = validate_name($firstname);
    $errors['lastname_error'] = validate_name($lastname);
    $errors['email_error'] = validate_email($email);
    $errors['password_error'] = validate_password($password);

    $errors = array_filter($errors); // Remove empty error messages

    if (!empty($errors)) {
        // Redirect back with errors
        $query = http_build_query($errors);
        header("Location: /pages/register.php?" . $query);
        exit;
    } else {
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
    }
} else {
    die("Invalid request method.");
}
?>
