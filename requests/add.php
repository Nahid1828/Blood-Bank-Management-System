<?php
include('../includes/db_connect.php');
session_start();

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipient_id = $_POST['recipient_id'];
    $blood_type = $_POST['blood_type'];
    $quantity = $_POST['quantity'];

    // Insert query
    $query = "INSERT INTO requests (recipient_id, blood_type, quantity, status) VALUES (?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isi", $recipient_id, $blood_type, $quantity);

    if ($stmt->execute()) {
        echo "Request submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Blood</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Request Blood</h2>
    <form method="POST" action="">
        <label for="recipient_id">Recipient ID:</label>
        <input type="number" name="recipient_id" required><br>

        <label for="blood_type">Blood Type:</label>
        <input type="text" name="blood_type" required><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br>

        <input type="submit" value="Submit Request">
    </form>
    <div class="stylish-box">
    <a href="../index.php" class="back-btn">Back to Home</a>
    </div>
</body>
</html>
