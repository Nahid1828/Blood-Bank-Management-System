<?php
include '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $recipient_id = $_GET['id'];

    // Delete recipient record
    $sql = "DELETE FROM recipients WHERE recipient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipient_id);

    if ($stmt->execute()) {
        echo "Recipient deleted successfully!";
        header("Location: view.php");
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid request!";
}
?>
