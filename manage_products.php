<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include database connection file
include('db_connection.php');

// Handle Add Product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->execute();
}

// Handle Update Product
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->execute();
}

// Handle Delete Product
if (isset($_POST['delete_product'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Handle Logout
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Fetch products
$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
}

$query = "SELECT * FROM products";
if ($searchQuery) {
    $query .= " WHERE name LIKE :searchQuery";
}

$stmt = $conn->prepare($query);
if ($searchQuery) {
    $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%');
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="style.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>

    <!-- Internal CSS Styling -->
    <style>
        /* General container styling */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header h1 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }

        /* Search form styling */
        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            padding: 8px;
            width: 60%;
            max-width: 400px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-form button {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }

        /* Product table styling */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .product-table th, .product-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .product-table td {
            color: black;
        }

        /* Product table header */
        .product-table th {
            background-color: #f4f4f4;
            color: #333;
        }

        /* Manage Products button */
        .manage-products {
            text-align: center;
            margin-top: 20px;
        }

        .manage-products a {
            background-color: #ffc107;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .manage-products a:hover {
            background-color: #e0a800;
        }

        /* Product form styling */
        .product-form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .product-form input[type="text"],
        .product-form input[type="number"] {
            padding: 8px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .product-form button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .product-form button:hover {
            background-color: #218838;
        }

        /* Logout Button */
        .logout-btn {
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 1.5em;
            }

            .search-form input[type="text"] {
                width: 80%;
            }

            .product-table {
                font-size: 14px;
            }

            .product-form {
                width: 80%;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Manage Products</h1>
    </header>

    <div class="container">
        <!-- Logout Button -->
        <a href="?logout=true" class="logout-btn">Logout</a>

        <!-- Search Form -->
        <div class="search-form">
            <form method="POST">
                <input type="text" name="search" placeholder="Search for products..." value="<?= htmlspecialchars($searchQuery); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <!-- Add Product Form -->
<div class="product-form">
    <h2>Add New Product</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Product Price" required>
        <button type="submit" name="add_product">Add Product</button>
    </form>
</div>

        <!-- Product Table -->
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($products): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name']); ?></td>
                            <td><?= htmlspecialchars($product['price']); ?></td>
                            <td>
                                <!-- Edit Product Form -->
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $product['id']; ?>">
                                    <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" placeholder="Product Name">
                                    <input type="number" name="price" value="<?= htmlspecialchars($product['price']); ?>" placeholder="Product Price">
                                    <button type="submit" name="update_product">Update</button>
                                </form>

                                <!-- Delete Product Form -->
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $product['id']; ?>">
                                    <button type="submit" name="delete_product">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</body>
</html>
