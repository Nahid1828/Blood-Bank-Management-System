<?php
include('../includes/db_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone_number = $_POST['phone_number'];

    // Check if recipient exists
    $query = "SELECT * FROM recipients WHERE phone_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $phone_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $recipient = $result->fetch_assoc();
        
        // Set session variables for the recipient
        $_SESSION['recipient_logged_in'] = true;
        $_SESSION['recipient_id'] = $recipient['recipient_id'];
        $_SESSION['recipient_name'] = $recipient['name'];
        
        header('Location: ../requests/add.php'); // Redirect to request page
        exit();
    } else {
        $error_message = "Invalid phone number. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipient Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Recipient Login</h2>
    <form method="POST" action="">
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required><br>

        <input type="submit" value="Login">
    </form>

    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    
    <div class="stylish-box">
    <a href="../index.php" class="back-btn">Back to Home</a>
    </div>
</body>
</html>
