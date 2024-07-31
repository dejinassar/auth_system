<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

include("../config/config.php");

$adminId = $_SESSION['id'];
$adminEmail = $_SESSION['email'];

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Fetch profile picture
    $profileStmt = $pdo->prepare("SELECT profile_picture FROM admin WHERE id = ?");
    $profileStmt->execute([$adminId]);
    $profilePic = $profileStmt->fetch(PDO::FETCH_ASSOC)['profile_picture'];

    } catch (PDOException $e) {
        die("Could not fetch user: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
        $stmt->execute([$firstname, $lastname, $email, $userId]);
        header("Location: Users.php");
        exit;
    } catch (PDOException $e) {
        die("Could not update user: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #000000;
            margin: 0;
            color: #ffffff;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #ffffff;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            padding-top: 20px;
        }
        .sidebar a {
            color: #ffffff;
            padding: 15px 20px;
            display: block;
            text-decoration: none;
            font-weight: bold;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar .active {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            margin-left: 250px;
            background-color: #000000;
        }
        .navbar {
            background-color: #343a40;
            color: #ffffff;
            margin-bottom: 20px;
        }
        .navbar .navbar-brand {
            color: #ffffff !important;
            margin-left: 20px;
        }
        .navbar .nav-link {
            color: #ffffff !important;
        }
        .navbar .nav-link:hover {
            color: #e0e0e0 !important;
        }
        .profile-pic {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .profile-pic {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 10px;
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
      
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #495057;
            color: #ffffff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            background-color: #ffffff;
            color: #000000;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="text-center mb-4">
        <div class="profile-info">
            <img src="<?php echo htmlspecialchars($profilePic ? $profilePic : 'default_profile_pic.jpg'); ?>" alt="Profile Picture">
     
            <h5 class="mt-2"><?php echo htmlspecialchars($adminEmail); ?></h5>
        </div>
        </div>
        <a href="Dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="users.php" class="active"><i class="fas fa-users"></i> Users</a>
        <a href="Messages.php"><i class="fas fa-envelope"></i> Messages</a>
        <a href="Logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <nav class="navbar">
            <a class="navbar-brand" href="#">Edit User</a>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit User</h5>
                        </div>
                        <div class="card-body">
                            <form action="edit_user.php?id=<?php echo htmlspecialchars($userId); ?>" method="POST">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="Users.php" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
