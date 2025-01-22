<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Database connection include kora
include('../includes/db_connect.php');

// Total donors count fetch kora
$query = "SELECT COUNT(*) AS total_donors FROM donors";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_donors = $row['total_donors'];

// Total recipients count fetch kora
$recipient_query = "SELECT COUNT(*) AS total_recipients FROM recipients";
$recipient_result = mysqli_query($conn, $recipient_query);
$recipient_row = mysqli_fetch_assoc($recipient_result);
$total_recipients = $recipient_row['total_recipients'];

// Total available blood
$inventory_query = "SELECT SUM(quantity) AS total_inventory FROM blood_inventory";
$inventory_result = mysqli_query($conn, $inventory_query);
$inventory_row = mysqli_fetch_assoc($inventory_result);
$total_inventory = $inventory_row['total_inventory'];

// Pending requests count
$request_query = "SELECT COUNT(*) AS pending_requests FROM requests WHERE status = 'Pending'";
$request_result = mysqli_query($conn, $request_query);
$request_row = mysqli_fetch_assoc($request_result);
$pending_requests = $request_row['pending_requests'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Welcome back, Admin!</p>
    </header>

    <!-- Dashboard Stats -->
    <section class="dashboard-stats">
        <h3>Total Donors: <?php echo $total_donors; ?></h3>
        <h3>Total Recipients: <?php echo $total_recipients; ?></h3>
        <h3>Total Available Blood Units: <?php echo $total_inventory; ?></h3>
        <h3>Pending Blood Requests: <?php echo $pending_requests; ?></h3>
    </section>

    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="../donor/add.php">Add Donor</a></li>
            <li><a href="../donor/view.php">View Donors</a></li>
            <li><a href="../recipient/add.php">Add Recipient</a></li>
            <li><a href="../recipient/view.php">View Recipients</a></li>
            <li><a href="../inventory/update.php">Update Blood Inventory</a></li>
            <li><a href="../requests/manage.php">Manage Blood Requests</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav> 
    <br>
    <div class="stylish-box">
    <a href="../index.php" class="back-btn">Back to Home</a>
    </div>
    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Blood Bank Management System. All rights reserved.</p>
    </footer>
</body>
</html>
