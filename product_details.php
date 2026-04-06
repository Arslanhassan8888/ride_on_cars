<?php
// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

/*
    Get product ID from URL.
    Cast to integer to prevent invalid input.
*/
$id = (int)($_GET['id'] ?? 0);

/*
    Retrieve a single product from the database.
*/
function getProduct($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/*
    Convert rating value into star symbols.
*/
function stars($rating)
{
    return str_repeat("★", (int)$rating);
}

/* Fetch product */
$product = getProduct($pdo, $id);

/* Stop execution if product not found */
if (!$product) {
    die("Product not found.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?></title>

    <!-- Favicon -->
    <link rel="icon" href="images/car_logo.png">

    <!-- Styles -->
    <link rel="stylesheet" href="css/style.css?v=<?= filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/product_details.css?v=<?= filemtime('css/product_details.css'); ?>">
</head>

<body>

    <!-- Accessibility link -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include 'header.php'; ?>

    <main id="main-content">

        <!-- Hidden main heading -->
        <h1 class="sr-only">Product Details</h1>

        <section class="product-details" aria-labelledby="product-details-heading">
            <h2 id="product-details-heading" class="sr-only">Product details section</h2>

            <!-- Product image -->
            <figure class="product-image">
                <img src="images/<?= htmlspecialchars($product['image']) ?>"
                     alt="<?= htmlspecialchars($product['name']) ?>">
            </figure>

            <!-- Product information -->
            <section class="product-info" aria-labelledby="product-info-heading">

                <h2 id="product-info-heading"><?= htmlspecialchars($product['name']) ?></h2>

                <!-- Rating -->
                <p class="rating"><?= stars($product['rating']) ?></p>

                <!-- Price -->
                <p class="price">£<?= number_format($product['price'], 2) ?></p>

                <!-- Description -->
                <p class="desc"><?= htmlspecialchars($product['description']) ?></p>

                <!-- Extra details -->
                <section class="extra-info" aria-labelledby="extra-info-heading">
                    <h3 id="extra-info-heading" class="sr-only">Additional product information</h3>
                    <p><strong>Age Range:</strong> <?= htmlspecialchars($product['age_range']) ?></p>
                    <p><strong>Stock:</strong> <?= htmlspecialchars($product['stock']) ?></p>
                </section>

                <!-- Long description -->
                <section aria-labelledby="product-information-heading">
                    <h3 id="product-information-heading">Product Information</h3>
                    <p><?= htmlspecialchars($product['long_description']) ?></p>
                </section>

                <!-- Actions -->
                <section class="actions" aria-labelledby="actions-heading">
                    <h3 id="actions-heading" class="sr-only">Product actions</h3>

                    <?php if (isset($_SESSION['user']) && isset($_SESSION['user_id'])): ?>
                        <a href="cart.php?action=add&id=<?= (int)$product['id'] ?>" class="btn-cart">
                            Add to Cart
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn-cart">
                            Login to Buy
                        </a>
                    <?php endif; ?>

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