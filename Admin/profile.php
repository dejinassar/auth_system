<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

include("../config/config.php");

$adminId = $_SESSION['id'];
$adminEmail = $_SESSION['email'];

try {
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE id = ?");
    $stmt->execute([$adminId]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not fetch admin: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    $profilePicture = $_FILES['profile_picture'];

    $updateFields = [];
    $updateValues = [];
    
    if (!empty($newEmail)) {
        $updateFields[] = "email = ?";
        $updateValues[] = $newEmail;
    }
    
    if (!empty($newPassword)) {
        $updateFields[] = "password = ?";
        $updateValues[] = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    if (!empty($profilePicture['name'])) {
        $profilePicturePath = 'uploads/' . basename($profilePicture['name']);
        move_uploaded_file($profilePicture['tmp_name'], $profilePicturePath);
        $updateFields[] = "profile_picture = ?";
        $updateValues[] = $profilePicturePath;
    }
    
    if (!empty($updateFields)) {
        $updateValues[] = $adminId;
        $sql = "UPDATE admin SET " . implode(', ', $updateFields) . " WHERE id = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($updateValues);
            header("Location: profile.php");
            exit;
        } catch (PDOException $e) {
            die("Could not update profile: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
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
            width: 100px;
            height: 100px;
            border-radius: 50%;
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
            <img src="<?php echo htmlspecialchars($admin['profile_picture'] ?? 'path_to_default_profile_pic.jpg'); ?>" class="profile-pic" alt="Profile Picture">
            <h5 class="mt-2"><?php echo htmlspecialchars($adminEmail); ?></h5>
        </div>
        <a href="Dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="Users.php"><i class="fas fa-users"></i> Users</a>
        <a href="Messages.php"><i class="fas fa-envelope"></i> Messages</a>
        <a href="profile.php" class="active"><i class="fas fa-user"></i> Profile</a>
        <a href="Logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <nav class="navbar">
            <a class="navbar-brand" href="#">Admin Profile</a>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Profile</h5>
                        </div>
                        <div class="card-body">
                            <form action="profile.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <small class="form-text text-muted">Leave empty if you do not want to change the password.</small>
                                </div>
                                <div class="form-group">
                                    <label for="profile_picture">Profile Picture</label>
                                    <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="Dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
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
