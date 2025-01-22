<?php
include '../includes/db_connect.php';

// Fetch all recipients
$sql = "SELECT * FROM recipients";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Recipients</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Recipient List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Blood Type</th>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['recipient_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['blood_type']; ?></td>
                    <td><?php echo $row['phone_number']; ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $row['recipient_id']; ?>">Update</a> |
                        <a href="delete.php?id=<?php echo $row['recipient_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="stylish-box">
    <a href="../admin/dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
