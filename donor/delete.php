<?php
include '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $donor_id = $_GET['id'];

    // Delete donor record
    $sql = "DELETE FROM donors WHERE donor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $donor_id);

    if ($stmt->execute()) {
        echo "Donor deleted successfully!";
        header("Location: view.php");
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid request!";
}
?>
