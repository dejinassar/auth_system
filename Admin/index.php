<?php
session_start();
include("../config/config.php");

$errors = [];
$error_msg = [];

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {
        $error_msg['email'] = "Email Address is Required.";
    }

    if (empty($password)) {
        $error_msg['password'] = "Password is Required.";
    }

    if (empty($error_msg)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Debugging output
                echo "Password from database: " . $user['password'] . "<br>";
                echo "Password input: " . $password . "<br>";
                
                if ($user['password'] === $password) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    header("Location: Dashboard.php");
                    exit;
                } else {
                    $errors[] = "Incorrect Email or Password.";
                }
            } else {
                $errors[] = "Incorrect Email or Password.";
            }
        } catch (PDOException $e) {
            $errors[] = "Login Failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login {
            background: #fff;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .alert {
            color: red;
            font-size: 15px;
            text-align: center;
            font-weight: 600;
        }
        .form__field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .validationError {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="login">
        <h1>Admin Login</h1>
        <br>
        <?php
        if (!empty($errors)) {
            foreach ($errors as $key => $value) {
                echo "<div class='alert'>$value</div>";
            }
        }
        ?>
        <form method="post" action="">
            <input type="email" name="email" class="form__field" placeholder="Email" />
            <?php
            if (isset($error_msg['email'])) {
                echo "<div class='validationError'>" . $error_msg['email'] . "</div>";
            }
            ?>
            <input type="password" name="password" class="form__field" placeholder="Password" />
            <?php
            if (isset($error_msg['password'])) {
                echo "<div class='validationError'>" . $error_msg['password'] . "</div>";
            }
            ?>
            <button type="submit" name="login" class="btn btn-primary btn-block btn-large">Log In</button>
        </form>
    </div>
</body>

</html>
