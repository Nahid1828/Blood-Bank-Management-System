<?php
include '../includes/db_connect.php';

// Get donor ID from URL
if (isset($_GET['id'])) {
    $donor_id = $_GET['id'];

    // Fetch donor details
    $sql = "SELECT * FROM donors WHERE donor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $donor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $donor = $result->fetch_assoc();
    } else {
        echo "Donor not found!";
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

    // Update donor details
    $sql = "UPDATE donors SET name = ?, age = ?, gender = ?, blood_type = ?, phone_number = ? WHERE donor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssi", $name, $age, $gender, $blood_type, $phone_number, $donor_id);

    if ($stmt->execute()) {
        echo "Donor updated successfully!";
        header("Location: view.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Donor</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Update Donor</h2>
    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo $donor['name']; ?>" required><br><br>
        <label>Age:</label><br>
        <input type="number" name="age" value="<?php echo $donor['age']; ?>" required><br><br>
        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="Male" <?php echo ($donor['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($donor['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select><br><br>
        <label>Blood Type:</label><br>
        <input type="text" name="blood_type" value="<?php echo $donor['blood_type']; ?>" required><br><br>
        <label>Phone Number:</label><br>
        <input type="text" name="phone_number" value="<?php echo $donor['phone_number']; ?>" required><br><br>
        <button type="submit">Update Donor</button>
    </form>
</body>
</html>
