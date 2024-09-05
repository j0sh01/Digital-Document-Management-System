<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: auth/login.php");
    exit();
}

require 'config/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $user_id = $_SESSION['user_id'];
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $upload_dir = 'uploads/';
        $file_path = $upload_dir . basename($file_name);

        // Ensure the uploads directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($file_tmp, $file_path)) {
            $sql = "INSERT INTO documents (user_id, file_name, file_type) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $user_id, $file_name, $file_type);
            if ($stmt->execute()) {
                $success = "Document uploaded successfully.";
            } else {
                $error = "Failed to save document information in the database.";
            }
            $stmt->close();
        } else {
            $error = "There was an error uploading your file.";
        }
    } else {
        $error = "No file uploaded or there was an upload error.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="container mt-5">
        <h2>Upload Document</h2>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <div id="loading" style="display:none;">
           <div class="spinner-border text-primary" role="status">
             <span class="sr-only">Uploading...</span>
           </div>
        </div>
        <form action="upload_document.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" class="form-control" placeholder="Enter document category">
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" name="tags" class="form-control" placeholder="Enter document tags (comma separated)">
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Choose a document to upload:</label>
                <input class="form-control" type="file" name="file" id="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>
<script>
    document.getElementById('uploadForm').addEventListener('submit', function() {
        document.getElementById('loading').style.display = 'block';
    });
</script>
</html>
