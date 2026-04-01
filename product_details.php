<?php
session_start();
require 'db.php';

// Get product ID safely
$id = $_GET['id'] ?? 0;

// Function to get single product
function getProductById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([(int)$id]);
    return $stmt->fetch();
}

// Function for stars
function renderStars($rating) {
    return str_repeat("★", (int)$rating);
}

// Fetch product
$product = getProductById($pdo, $id);

// If not found
if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?></title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/product_details.css?v=2">
</head>

<body>

<?php include 'header.php'; ?>

<main>

    <!-- PRODUCT DETAILS -->
    <section class="product-details">

        <!-- IMAGE -->
        <figure class="product-image">
            <img src="images/<?= htmlspecialchars($product['image']) ?>" 
                 alt="<?= htmlspecialchars($product['name']) ?>">
        </figure>

        <!-- INFO -->
        <section class="product-info">

            <h1><?= htmlspecialchars($product['name']) ?></h1>

            <p class="rating">
                <?= renderStars($product['rating']) ?>
            </p>

            <p class="price">
                £<?= number_format($product['price'], 2) ?>
            </p>

            <p class="desc">
                <?= htmlspecialchars($product['description']) ?>
            </p>

            <!-- EXTRA INFO -->
            <section class="extra-info">
                <p><strong>Age Range:</strong> <?= htmlspecialchars($product['age_range']) ?></p>
                <p><strong>Stock:</strong> <?= htmlspecialchars($product['stock']) ?></p>
            </section>

            <!-- LONG DESCRIPTION -->
            <section>
                <h2>Product Information</h2>
                <p><?= htmlspecialchars($product['long_description']) ?></p>
            </section>

            <!-- ACTIONS -->
            <section class="actions">

                <!-- Add to cart (login required) -->
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="cart.php?action=add&id=<?= $product['id'] ?>" class="btn-cart">
                        Add to Cart
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn-cart">
                        Login to Buy
                    </a>
                <?php endif; ?>

                <!-- Back -->
                <a href="products.php" class="btn-back">
                    ← Back to Products
                </a>

            </section>

        </section>

    </section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>