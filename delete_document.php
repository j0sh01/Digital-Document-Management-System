<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $document_id = intval($_POST['id']);

    // Fetch the document details from the database
    $sql = "SELECT * FROM documents WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $document_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $document = $result->fetch_assoc();
        $file_path = '../uploads/' . $document['file_name'];

        // Delete the file from the server
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Delete the document record from the database
        $sql = "DELETE FROM documents WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $document_id, $_SESSION['user_id']);
        $stmt->execute();

        // Redirect to the view documents page with a success message
        $_SESSION['success_message'] = "Document deleted successfully.";
        header("Location: view_documents.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Document not found or you don't have permission to delete it.";
        header("Location: view_documents.php");
        exit();
    }
}

$conn->close();
?>
