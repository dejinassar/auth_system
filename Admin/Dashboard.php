<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

include("../config/config.php");

$adminId = $_SESSION['id'];
$adminEmail = $_SESSION['email'];

// Fetch the total number of users and messages
try {
    $userStmt = $pdo->query("SELECT COUNT(*) AS total_users FROM users");
    $userCount = $userStmt->fetch(PDO::FETCH_ASSOC)['total_users'];

    $messageStmt = $pdo->query("SELECT COUNT(*) AS total_messages FROM contacts");
    $messageCount = $messageStmt->fetch(PDO::FETCH_ASSOC)['total_messages'];

    // Fetch profile picture
    $profileStmt = $pdo->prepare("SELECT profile_picture FROM admin WHERE id = ?");
    $profileStmt->execute([$adminId]);
    $profilePic = $profileStmt->fetch(PDO::FETCH_ASSOC)['profile_picture'];
} catch (PDOException $e) {
    die("Could not fetch data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #2c2c2c;
            color: #ffffff;
            margin: 0;
        }
        .navbar {
            margin-bottom: 0;
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
            background-color: #1a1a1a;
            padding: 10px 15px;
        }
        .navbar .navbar-brand, .navbar .nav-link {
            color: #ffffff;
        }
        .navbar .navbar-brand:hover, .navbar .nav-link:hover {
            color: #d1d1d1;
        }
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .sidebar {
            width: 250px;
            background-color: #1a1a1a;
            color: #ffffff;
            position: fixed;
            top: 56px; /* Height of the navbar */
            bottom: 0;
            padding-top: 20px;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar .profile-info {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
        }
        .sidebar .profile-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }
        .sidebar .profile-info h5 {
            margin-top: 10px;
            color: #ffffff;
        }
        .sidebar a {
            color: #ffffff;
            padding: 15px 20px;
            display: block;
            text-decoration: none;
            font-weight: bold;
        }
        .sidebar a:hover {
            background-color: #333333;
        }
        .sidebar .active {
            background-color: #444444;
        }
        .content {
            margin-left: 250px;
            margin-top: 56px; /* Height of the navbar */
            padding: 40px;
            flex-grow: 1;
            background-color: #2c2c2c;
        }
        .welcome-card {
            background-color: #333333;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 40px;
            text-align: center;
        }
        .summary-box {
            background-color: #444444;
            color: #ffffff;
            border-radius: 10px;
            padding: 10px;
            margin-right: 10px;
            text-align: center;
            flex: 1;
        }
        .summary-box h3 {
            margin: 0;
        }
        .summary-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                        <img src="<?php echo htmlspecialchars($profilePic ? $profilePic : 'default_profile_pic.jpg'); ?>" alt="Profile Picture" class="profile-pic">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="Logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="sidebar">
        <div class="profile-info">
            <img src="<?php echo htmlspecialchars($profilePic ? $profilePic : 'default_profile_pic.jpg'); ?>" alt="Profile Picture">
            <h5><?php echo htmlspecialchars($adminEmail); ?></h5>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="Users.php"><i class="fas fa-users"></i> Users</a>
            <a class="nav-link" href="Messages.php"><i class="fas fa-envelope"></i> Messages</a>
        </nav>
    </div>

    <div class="content">
        <div class="welcome-card">
            <h4>Welcome, <?php echo htmlspecialchars($adminEmail); ?>!</h4>
            <p>This is your admin dashboard. You can manage your website here.</p>
        </div>

        <div class="summary-container">
            <div class="summary-box">
                <h3>Total Users</h3>
                <p><?php echo htmlspecialchars($userCount); ?></p>
            </div>

            <div class="summary-box">
                <h3>Total Messages</h3>
                <p><?php echo htmlspecialchars($messageCount); ?></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
