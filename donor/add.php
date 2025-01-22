<?php
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $blood_type = $_POST['blood_type'];
    $phone_number = $_POST['phone_number'];

    // Insert donor into database
    $sql = "INSERT INTO donors (name, age, gender, blood_type, phone_number) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $name, $age, $gender, $blood_type, $phone_number);

    if ($stmt->execute()) {
        echo "Donor added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Donor</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Add Donor</h2>
    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>
        <label>Age:</label><br>
        <input type="number" name="age" required><br><br>
        <label>Gender:</label><br>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>
        <label>Blood Type:</label><br>
        <input type="text" name="blood_type" required><br><br>
        <label>Phone Number:</label><br>
        <input type="text" name="phone_number" required><br><br>
        <button type="submit">Add Donor</button>
    </form>
    <div class="stylish-box">
    <a href="../admin/dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
