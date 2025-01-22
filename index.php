<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Management System</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to the Blood Bank Management System</h1>
            <p>Your health is our priority! Help save lives by donating blood.</p>
        </header>
        
        <div class="options">
            <h2>Login as:</h2>
            <ul>
                <li><a href="admin/login.php" class="btn">Admin Login</a></li>
                <li><a href="recipient/login.php" class="btn">Recipient Login</a></li>
            </ul>
        </div>
    </div>
     <footer>
        <p>&copy; <?php echo date("Y"); ?> Blood Bank Management System. All rights reserved.</p>
    </footer>
</body>
</html>
