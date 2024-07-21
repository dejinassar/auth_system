<?php include('../includes/header.php'); ?>
<h1>Login</h1>
<form action="../actions/login_action.php" method="post">
    <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Login</button>
</form>
<?php include('../includes/footer.php'); ?>
