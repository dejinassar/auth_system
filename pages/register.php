<?php include('../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="/actions/register_action.php" method="post">
            <div class="mb-4">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" required>
                <?php if (isset($_GET['firstname_error'])): ?>
                    <p style="color: red;"><?php echo $_GET['firstname_error']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" required>
                <?php if (isset($_GET['lastname_error'])): ?>
                    <p style="color: red;"><?php echo $_GET['lastname_error']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <?php if (isset($_GET['email_error'])): ?>
                    <p style="color: red;"><?php echo $_GET['email_error']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($_GET['password_error'])): ?>
                    <p style="color: red;"><?php echo $_GET['password_error']; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
<?php include('../includes/footer.php'); ?>
</body>
</html>
