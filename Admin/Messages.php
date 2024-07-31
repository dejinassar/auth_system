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
    $stmt = $pdo->query("SELECT * FROM contacts");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch profile picture
    $profileStmt = $pdo->prepare("SELECT profile_picture FROM admin WHERE id = ?");
    $profileStmt->execute([$adminId]);
    $profilePic = $profileStmt->fetch(PDO::FETCH_ASSOC)['profile_picture'];
} catch (PDOException $e) {
    die("Could not fetch contacts: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
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
        .table th, .table td {
            vertical-align: middle;
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
        <a href="Users.php"><i class="fas fa-users"></i> Users</a>
        <a href="Messages.php" class="active"><i class="fas fa-envelope"></i> Messages</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        
        <a href="Logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <nav class="navbar">
            <a class="navbar-brand" href="#">Messages</a>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Inbox</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $contact): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($contact['id']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['message']); ?></td>
                                        <td>
                                            <a href="edit_message.php?id=<?php echo htmlspecialchars($contact['id']); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="delete_message.php?id=<?php echo htmlspecialchars($contact['id']); ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <a href="Dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
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
