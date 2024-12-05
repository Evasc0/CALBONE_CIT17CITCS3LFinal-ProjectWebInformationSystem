<?php
session_start();
include('db_connection.php');
include('includes/header.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Redirect to login if not logged in
    exit;
}

// Fetch all products
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Add Product - Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);

    if ($stmt->execute()) {
        $success = "Product added successfully!";
    } else {
        $error = "Error adding product!";
    }
}

?>

<main>
    <div class="container">
        <h2>Product Management</h2>

        <!-- Add Product Form -->
        <h3>Add New Product</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="text" name="price" placeholder="Price" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>

        <?php if (isset($success)): ?>
            <p style="color: green;"><?= $success ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <!-- List of Products -->
        <h3>Existing Products</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td>
                        <a href="update.php?id=<?= $product['id'] ?>">Edit</a> |
                        <a href="delete.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</main>

<?php include('includes/footer.php'); ?>
