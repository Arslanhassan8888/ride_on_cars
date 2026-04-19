<?php

require 'auth.php';
require '../db.php';


/* --GET PRODUCTS-- */
/* Retrieve all products (latest first) */
/* Returns an array of products */
function getProducts($pdo)
{   /* Prepare and execute select statement to get all products ordered by id descending */
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}


/* --DATA-- */
/* Get all products to display in the dashboard table */
$products = getProducts($pdo);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="../images/car_logo.png">

    <!-- STYLES -->
    <link rel="stylesheet" href="../css/style.css?v=<?php echo filemtime('../css/style.css'); ?>">
    <link rel="stylesheet" href="../css/admin.css?v=<?php echo filemtime('../css/admin.css'); ?>">
</head>

<body>

    <!-- SKIP LINK -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- HEADER -->
    <?php include '../header.php'; ?>

    <!-- MAIN -->
    <main id="main-content" tabindex="-1">

        <!-- ADMIN CONTAINER -->
        <section class="admin-container">

            <!-- HEADER -->
            <header class="admin-header">
                <h1>Admin Dashboard</h1>
                <p>Manage your products</p>

                <!-- ACTIONS -->
                <nav class="admin-actions">
                    <a href="add_product.php" class="btn-add">Add Product</a>
                    <a href="manage_users.php" class="btn-users">Manage Users</a>
                </nav>
            </header>

            <!-- TABLE SECTION -->
            <section class="admin-table-section">
                <h2 class="visually-hidden">Products management table</h2>

                <!-- TABLE -->
                <table class="admin-table">

                    <!-- TABLE HEADER -->
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Rating</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <!-- TABLE BODY -->
                    <tbody>

                        <!-- PRODUCT LOOP -->
                        <?php foreach ($products as $product): ?>

                            <tr>

                                <!-- IMAGE -->
                                <td>
                                    <img src="../images/<?= htmlspecialchars($product['image']) ?>"
                                        alt="<?= htmlspecialchars($product['name']) ?>">
                                </td>

                                <!-- PRODUCT INFO -->
                                <td>
                                    <strong><?= htmlspecialchars($product['name']) ?></strong>
                                    <p><?= htmlspecialchars($product['description']) ?></p>
                                </td>

                                <!-- PRICE -->
                                <td>£<?= number_format($product['price'], 2) ?></td>

                                <!-- RATING -->
                                <td><?= (int)$product['rating'] ?></td>

                                <!-- CATEGORY -->
                                <td><?= htmlspecialchars($product['brand'] ?? 'N/A') ?></td>

                                <!-- ACTIONS -->
                                <td class="actions">

                                    <!-- EDIT -->
                                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn-edit"
                                        aria-label="Edit <?= htmlspecialchars($product['name']) ?>">Edit</a>

                                    <form method="POST" action="delete_product.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                        <button type="submit" class="btn-delete" aria-label="Delete <?= htmlspecialchars($product['name']) ?>">Delete</button>
                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </section>

        </section>

    </main>

    <!-- FOOTER -->
    <?php include '../footer.php'; ?>

</body>

</html>