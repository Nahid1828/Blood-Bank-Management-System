<?php
include('../includes/db_connect.php');
session_start();

// Fetch pending requests
$query = "SELECT r.request_id, r.blood_type, r.quantity, r.status, rec.name AS recipient_name
          FROM requests r
          JOIN recipients rec ON r.recipient_id = rec.recipient_id
          WHERE r.status = 'Pending'";
$result = $conn->query($query);

if (!$result) {
    die("Query Error: " . $conn->error);
}

// Handle Approve/Reject
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];

    if ($action === 'Approve') {
        // Fetch request details
        $stmt = $conn->prepare("SELECT blood_type, quantity FROM requests WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $request_data = $stmt->get_result()->fetch_assoc();

        if ($request_data) {
            $blood_type = $request_data['blood_type'];
            $quantity = $request_data['quantity'];

            // Check if sufficient stock is available
            $stmt = $conn->prepare("SELECT quantity FROM blood_inventory WHERE blood_type = ?");
            $stmt->bind_param("s", $blood_type);
            $stmt->execute();
            $inventory_data = $stmt->get_result()->fetch_assoc();

            if ($inventory_data && $inventory_data['quantity'] >= $quantity) {
                // Deduct from inventory
                $stmt = $conn->prepare("UPDATE blood_inventory SET quantity = quantity - ? WHERE blood_type = ?");
                $stmt->bind_param("is", $quantity, $blood_type);
                $stmt->execute();

                // Update request status to Approved
                $stmt = $conn->prepare("UPDATE requests SET status = 'Approved' WHERE request_id = ?");
                $stmt->bind_param("i", $request_id);
                $stmt->execute();

                $message = "Request Approved and Inventory Updated.";
            } else {
                $message = "Insufficient stock for this blood type.";
            }
        }
    } elseif ($action === 'Reject') {
        // Update request status to Rejected
        $stmt = $conn->prepare("UPDATE requests SET status = 'Rejected' WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $message = "Request Rejected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blood Requests</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Manage Blood Requests</h2>
    <?php if (!empty($message)) echo "<p style='color: green;'>$message</p>"; ?>
    <table border="1">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Recipient Name</th>
                <th>Blood Type</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><?php echo $row['recipient_name']; ?></td>
                <td><?php echo $row['blood_type']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                        <button type="submit" name="action" value="Approve">Approve</button>
                        <button type="submit" name="action" value="Reject">Reject</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="stylish-box">
    <a href="../admin/dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
