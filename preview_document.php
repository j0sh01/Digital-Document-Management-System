<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: auth/login.php");
    exit();
}

require 'config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view_documents.php");
    exit();
}

$document_id = $_GET['id'];

$sql = "SELECT * FROM documents WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $document_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: view_documents.php");
    exit();
}

$document = $result->fetch_assoc();
$file_path = 'uploads/' . $document['file_name'];
$file_type = $document['file_type'];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/nav.php'; ?>

    <div class="container mt-5">
        <h2>Document Preview</h2>
        <?php if (in_array($file_type, ['pdf'])): ?>
            <embed src="<?php echo htmlspecialchars($file_path); ?>" type="application/pdf" width="100%" height="600px" />
        <?php elseif (in_array($file_type, ['jpg', 'jpeg', 'png', 'gif'])): ?>
            <img src="<?php echo htmlspecialchars($file_path); ?>" alt="Document Image" class="img-fluid" />
        <?php elseif (in_array($file_type, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'])): ?>
            <iframe src="https://docs.google.com/viewer?url=<?php echo urlencode($file_path); ?>&embedded=true" width="100%" height="600px"></iframe>
        <?php else: ?>
            <p>Preview not available for this file type.</p>
        <?php endif; ?>
        <a href="view_documents.php" class="btn btn-secondary mt-3">Back to Documents</a>
    </div>
</body>
</html>
