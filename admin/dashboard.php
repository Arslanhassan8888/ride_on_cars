<?php

require 'auth.php';
require '../db.php';

/* GET PRODUCTS */
function getProducts($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

/* DATA */
$products = getProducts($pdo);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="../images/car_logo.png">

    <link rel="stylesheet" href="../css/style.css?v=<?php echo filemtime('../css/style.css'); ?>">
    <link rel="stylesheet" href="../css/admin.css?v=<?php echo filemtime('../css/admin.css'); ?>">
</head>

<body>

    <?php include '../header.php'; ?>

    <main>

        <section class="admin-container">

            <header class="admin-header">
                <h1>Admin Dashboard</h1>
                <p>Manage your products</p>

                <nav class="admin-actions">
                    <a href="add_product.php" class="btn-add">Add Product</a>
                    <a href="manage_users.php" class="btn-users">Manage Users</a>
                </nav>
            </header>

            <section class="admin-table-section">
                <h2 class="visually-hidden-heading">Products management table</h2>

                <table class="admin-table">

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

                    <tbody>

                        <?php foreach ($products as $product): ?>

                            <tr>

                                <td>
                                    <img src="../images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                </td>

                                <td>
                                    <strong><?= htmlspecialchars($product['name']) ?></strong>
                                    <p><?= htmlspecialchars($product['description']) ?></p>
                                </td>

                                <td>£<?= number_format($product['price'], 2) ?></td>

                                <td><?= (int)$product['rating'] ?></td>

                                <td><?= htmlspecialchars($product['brand'] ?? 'N/A') ?></td>

                                <td class="actions">

                                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn-edit">
                                        Edit
                                    </a>

                                    <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn-delete">
                                        Delete
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </section>

        </section>

    </main>

    <?php include '../footer.php'; ?>



</body>

</html>