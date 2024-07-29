<?php include('../includes/header.php'); ?>
<h1>Contact Us</h1>
<?php if (isset($_GET['success'])): ?>
    <p>Thank you for your message. We will get back to you soon.</p>
<?php endif; ?>
<form action="/actions/contact_action.php" method="post">
    <div class="mb-4">
        <label>Name</label>
        <input type="text" name="name" required>
        <?php if (isset($_GET['name_error'])): ?>
            <p style="color: red;"><?php echo $_GET['name_error']; ?></p>
        <?php endif; ?>
    </div>
    <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" required>
        <?php if (isset($_GET['email_error'])): ?>
            <p style="color: red;"><?php echo $_GET['email_error']; ?></p>
        <?php endif; ?>
    </div>
    <div class="mb-4">
        <label>Message</label>
        <textarea name="message" required></textarea>
        <?php if (isset($_GET['message_error'])): ?>
            <p style="color: red;"><?php echo $_GET['message_error']; ?></p>
        <?php endif; ?>
    </div>
    <button type="submit">Send</button>
</form>
<?php include('../includes/footer.php'); ?>
