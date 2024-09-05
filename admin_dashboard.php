<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome, Admin <?php echo $_SESSION['username']; ?>!</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="admin_dashboard.php">DDMS Admin</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="admin_dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Upload Document</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">View Documents</a>
                    </li>
                </ul>
            </div>
            <a href="auth/logout.php" class="btn btn-danger">Logout</a>
        </nav>

        <div class="mt-4">
            <h2>Admin Dashboard</h2>
            <p>Manage users, documents, and system settings here.</p>
        </div>
    </div>
</body>
</html>
