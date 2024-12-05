<?php
session_start();
include('db_connection.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add product to database
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);

    if ($stmt->execute()) {
        header("Location: manage_products.php");
        exit;
    } else {
        $error = "Error adding product. Please try again.";
    }
}
?>

<main>
<link rel="stylesheet" type="text/css" href="style.css">

    <div class="container">
        <h2>Add New Product</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="text" name="price" placeholder="Price" required>
            <button type="submit">Add Product</button>
        </form>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>
