<?php
include '../includes/db_connect.php';

// Fetch all blood inventory records
$sql = "SELECT * FROM blood_inventory";
$result = $conn->query($sql);

// Handle inventory update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['inventory'] as $inventory_id => $quantity) {
        $sql_update = "UPDATE blood_inventory SET quantity = ? WHERE inventory_id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ii", $quantity, $inventory_id);

        if (!$stmt->execute()) {
            echo "Error updating inventory for ID $inventory_id: " . $stmt->error;
        }
    }
    echo "Inventory updated successfully!";
    header("Location: update.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Blood Inventory</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Update Blood Inventory</h2>
    <form method="POST" action="">
        <table border="1">
            <thead>
                <tr>
                    <th>Blood Type</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['blood_type']; ?></td>
                        <td>
                            <input type="number" name="inventory[<?php echo $row['inventory_id']; ?>]" 
                                   value="<?php echo $row['quantity']; ?>" min="0" required>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <button type="submit">Update Inventory</button>
    </form>
    <div class="stylish-box">
    <a href="../admin/dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
