<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}

// Get the logged-in username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="style.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Internal CSS Styling -->
    <style>
        /* General container styling */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header styling */
        header h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        header a.btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        header a.btn:hover {
            background-color: #0056b3;
        }

        /* Main content */
        main {
            text-align: center;
            padding: 20px;
        }

        /* CTA buttons */
        .cta-buttons {
            margin-top: 20px;
        }

        .cta-buttons .btn {
            background-color: #28a745;
            margin: 10px;
        }

        .cta-buttons .btn:hover {
            background-color: #218838;
        }

        /* Manage products button */
        .manage-products {
            margin-top: 20px;
        }

        .manage-products .btn {
            background-color: #ffc107;
            margin: 10px;
        }

        .manage-products .btn:hover {
            background-color: #e0a800;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2em;
            }

            .container {
                padding: 10px;
            }

            .cta-buttons .btn, .manage-products .btn {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>

</head>
<body>

    <header>
        <h1>Welcome to your Dashboard, <?= htmlspecialchars($username); ?>!</h1>
        <a href="logout.php" class="btn">Logout</a>
    </header>

    <main>
        <div class="container">
            <!-- Welcome Message -->
            <h2>Welcome to the Information System</h2>
            
            <!-- Brief Description -->
            <p>This system allows you to manage products, users, and other important data efficiently. You can easily add, edit, and delete products, view your current inventory, and perform other essential tasks related to the management of your system.</p>
            
            <!-- Manage Products Button -->
            <div class="manage-products">
                <a href="manage_products.php" class="btn">Manage Products</a>
            </div>
            <!-- Call-to-action Buttons -->
            <div class="cta-buttons">
                <a href="#get-started" class="btn">Get Started</a>
                <a href="#learn-more" class="btn">Learn More</a>
            </div>
            
        </div>
    </main>

</body>
</html>
<?php include('includes/footer.php'); ?>
