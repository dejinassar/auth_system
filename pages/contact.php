<?php include('../includes/header.php'); ?>
<h1>Contact Us</h1>
<?php if (isset($_GET['success'])): ?>
    <p>Thank you for your message. We will get back to you soon.</p>
<?php endif; ?>
<form action="/actions/contact_action.php" method="post">
    <div class="mb-4">
        <label>Name</label>
        <input type="text" name="name" required>
    </div>
    <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <div class="mb-4">
        <label>Message</label>
        <textarea name="message" required></textarea>
    </div>
    <button type="submit">Send</button>
</form>
<?php include('../includes/footer.php'); ?>
