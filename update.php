<?php
session_start();
include('db_connection.php');
include('includes/header.php');

// Fetch product by ID
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Product not found!";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle update
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':id', $product_id);

    if ($stmt->execute()) {
        header("Location: manage_products.php");
        exit;
    } else {
        $error = "Error updating product. Please try again.";
    }
}
?>

<main>
    <div class="container">
        <h2>Update Product</h2>
        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" placeholder="Product Name" required>
            <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>" placeholder="Price" required>
            <button type="submit">Update Product</button>
        </form>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>
