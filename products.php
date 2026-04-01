<?php
session_start();
require 'db.php';

/* GET PRODUCTS */
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/products.css">
</head>

<body>

<?php include 'header.php'; ?>

<main>

    <!-- HERO -->
    <section class="products-hero">
        <h1>Electric Ride-On Cars</h1>
        <p>Explore our collection of amazing ride-on cars for kids</p>
    </section>

    <!-- PRODUCTS GRID -->
    <section class="products-grid">

        <?php foreach ($products as $product): ?>

            <article class="product-card">

                <figure>
                    <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                </figure>

                <h2><?= htmlspecialchars($product['name']) ?></h2>

                <p class="rating">
                    <?= str_repeat("★", $product['rating']) ?>
                </p>

                <p class="desc">
                    <?= htmlspecialchars($product['description']) ?>
                </p>

                <p class="price">
                    £<?= number_format($product['price'], 2) ?>
                </p>

                <section class="actions">
                    <a href="#" class="btn-cart">Add to Cart</a>
                    <a href="#" class="btn-info">More Info</a>
                </section>

            </article>

        <?php endforeach; ?>

    </section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>