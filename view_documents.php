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
    <title>View Documents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="container mt-5">
        <h2>Your Uploaded Documents</h2>


        <!-- Search and Filter Form -->
<form method="GET" action="view_documents.php" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by file name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        </div>
        <div class="col-md-3">
            <select name="file_type" class="form-control">
                <option value="">All Types</option>
                <option value="pdf" <?php echo (isset($_GET['file_type']) && $_GET['file_type'] == 'pdf') ? 'selected' : ''; ?>>PDF</option>
                <option value="doc" <?php echo (isset($_GET['file_type']) && $_GET['file_type'] == 'doc') ? 'selected' : ''; ?>>Word</option>
                <option value="xls" <?php echo (isset($_GET['file_type']) && $_GET['file_type'] == 'xls') ? 'selected' : ''; ?>>Excel</option>
                <!-- Add more file types as needed -->
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="uploaded_at" class="form-control" value="<?php echo isset($_GET['uploaded_at']) ? htmlspecialchars($_GET['uploaded_at']) : ''; ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>



        <!-- Success/Error Message Display -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; ?></div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error_message']; ?></div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Sr</th>
                    <th>File Name</th>
                    <th>File Type</th>
                    <th>Uploaded At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM documents WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                $sr = 1;

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $sr++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['file_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['file_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['uploaded_at']) . "</td>";
                    echo "<td>";
                    echo "<a href='preview_document.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>Preview</a> ";
                    echo "<form action='delete_document.php' method='post' style='display:inline-block;'>";
                    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this document?');\">Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }

                $stmt->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
