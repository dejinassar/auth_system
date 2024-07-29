<?php include('../includes/header.php'); ?>
<h1>Login</h1>
<form action="../actions/login_action.php" method="post">
    <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" required>
        <?php if (isset($_GET['email_error'])): ?>
                    <p style="color: red;"><?php echo $_GET['email_error']; ?></p>
                <?php endif; ?>
            
    </div>
    <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" required>
        <?php if (isset($_GET['password_error'])): ?>
                    <p style="color: red;"><?php echo $_GET['password_error']; ?></p>
                <?php endif; ?>
            
    </div>
    <!-- <div class="mb-4 remember-me">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember Me</label>
    </div> -->
    <button type="submit">Login</button>
</form>
<?php include('../includes/footer.php'); ?>
