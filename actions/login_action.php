<?php
session_start();
require '../config/config.php';

function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    return "";
}

function validate_password($password) {
    if (empty($password)) {
        return "Password cannot be empty.";
    }
    return "";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
  //  $remember = isset($_POST['remember']); // Check if "Remember Me" is checked

    $errors = [];
    $errors['email_error'] = validate_email($email);
    $errors['password_error'] = validate_password($password);

    $errors = array_filter($errors); // Remove empty error messages

    if (!empty($errors)) {
        // Redirect back with errors
        $query = http_build_query($errors);
        header("Location: /pages/login.php?" . $query);
        exit;
    } else {
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

                // If "Remember Me" is checked, set cookies
                // if ($remember) {
                //     setcookie('user_id', $user['id'], time() + (86400 * 30), "/"); // 86400 = 1 day
                //     setcookie('firstname', $user['firstname'], time() + (86400 * 30), "/");
                //     setcookie('lastname', $user['lastname'], time() + (86400 * 30), "/");
                // }

                header('Location: /pages/dashboard.php');
                exit();
            } else {
                // Invalid email or password
                header('Location: /pages/login.php?email_error=Invalid email or password.');
                exit();
            }
        } catch (PDOException $e) {
            // Handle potential errors
            header('Location: /pages/login.php?email_error=Database error: ' . $e->getMessage());
            exit();
        }
    }
} else {
    echo 'Invalid request method.';
}
?>
