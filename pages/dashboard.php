<?php
session_start();
require '../config/config.php';
include('../includes/header.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php');
    exit();
}

// Fetch the user details
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo 'User not found.';
    exit();
}
?>
<h1>Dashboard</h1>
<p>Welcome, <?php echo htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']); ?>!</p>
<?php if (!empty($user['profile_picture'])): ?>
    <img class="profile-picture" src="../assets/images/profile_pictures/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">
<?php endif; ?>
<form action="../actions/update_profile.php" method="post" enctype="multipart/form-data">
    <div class="mb-4">
        <label>First Name</label>
        <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
    </div>
    <div class="mb-4">
        <label>Last Name</label>
        <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
    </div>
    <div class="mb-4">
        <label>Profile Picture</label>
        <input type="file" name="profile_picture">
    </div>
    <button type="submit">Update Profile</button>
</form>
<form action="../actions/reset_password.php" method="post">
    <div class="mb-4">
        <label>New Password</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Reset Password</button>
</form>
<?php include('../includes/footer.php'); ?>
