<?php
// Start the session
session_start();

// Include the database connection file
include('db_connection.php');

// Define error messages
$error_message = "";

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Get user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        $error_message = "Both fields are required.";
    } else {
        // Prepare the SQL query to fetch user details
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Store user data in the session
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id']; // Assuming you have an 'id' column

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>

    <header>
        <h1>Welcome to the Product Information System</h1>
    </header>

    <main>
        <div class="container">
            <h2>Login</h2>
            
            <!-- Show error message if login fails -->
            <?php if ($error_message): ?>
                <div class="error"><?= htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <!-- Login form -->
            <form method="POST" action="">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" name="login" class="btn">Login</button>
            </form>

            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </main>

</body>
</html>
<?php include('includes/footer.php'); ?>
