<?php
include '../includes/db_connect.php';

// Get recipient ID from URL
if (isset($_GET['id'])) {
    $recipient_id = $_GET['id'];

    // Fetch recipient details
    $sql = "SELECT * FROM recipients WHERE recipient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $recipient = $result->fetch_assoc();
    } else {
        echo "Recipient not found!";
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $blood_type = $_POST['blood_type'];
    $phone_number = $_POST['phone_number'];

    // Update recipient details
    $sql = "UPDATE recipients SET name = ?, age = ?, gender = ?, blood_type = ?, phone_number = ? WHERE recipient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssi", $name, $age, $gender, $blood_type, $phone_number, $recipient_id);

    if ($stmt->execute()) {
        echo "Recipient updated successfully!";
        header("Location: view.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Recipient</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Update Recipient</h2>
    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo $recipient['name']; ?>" required><br><br>
        <label>Age:</label><br>
        <input type="number" name="age" value="<?php echo $recipient['age']; ?>" required><br><br>
        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="Male" <?php echo ($recipient['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($recipient['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select><br><br>
        <label>Blood Type:</label><br>
        <input type="text" name="blood_type" value="<?php echo $recipient['blood_type']; ?>" required><br><br>
        <label>Phone Number:</label><br>
        <input type="text" name="phone_number" value="<?php echo $recipient['phone_number']; ?>" required><br><br>
        <button type="submit">Update Recipient</button>
    </form>
</body>
</html>
