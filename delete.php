<?php
session_start();
include('db_connection.php');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id);

    if ($stmt->execute()) {
        header("Location: manage_products.php"); // Redirect back to product management page
        exit;
    } else {
        echo "Error deleting product.";
    }
} else {
    echo "No product ID specified.";
}
?>
