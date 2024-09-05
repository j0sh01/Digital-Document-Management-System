<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: auth/login.php");
    exit();
}

require 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/nav.php'; ?>
    <div class="container mt-5">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <!-- Document Statistics Section -->
        <div class="container mt-5">
            <h2>Document Statistics</h2>
            <div class="row">
                <?php
                $categories = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'png'];
                foreach ($categories as $category) {
                    $sql = "SELECT COUNT(*) AS count FROM documents WHERE user_id = ? AND file_type = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("is", $_SESSION['user_id'], $category);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count = $result->fetch_assoc()['count'];

                    echo "<div class='col-md-2'>";
                    echo "<div class='card'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . strtoupper($category) . "</h5>";
                    echo "<p class='card-text'>" . $count . " document(s)</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    $stmt->close();
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
