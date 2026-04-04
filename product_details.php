<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

/* GET ID */
$id = (int)($_GET['id'] ?? 0);

/* GET PRODUCT */
function getProduct($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/* STARS */
function stars($rating)
{
    return str_repeat("★", (int)$rating);
}

/* DATA */
$product = getProduct($pdo, $id);

if (!$product) {
    die("Product not found.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/product_details.css?v=<?php echo filemtime('css/product_details.css'); ?>">
</head>

<body>

<?php include 'header.php'; ?>

<main>

    <!-- PAGE MAIN HEADING (for accessibility) -->
    <h1 class="sr-only">Product Details</h1>

    <section class="product-details">
        <h2 class="sr-only">Electrical Car</h2>

        <!-- IMAGE -->
        <figure class="product-image">
            <img
                src="images/<?php echo htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8'); ?>"
                alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?>">
        </figure>

        <!-- INFO -->
        <section class="product-info">

            <!-- changed from h1 to h2 -->
            <h2><?php echo htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8'); ?></h2>

            <p class="rating">
                <?php echo stars($product['rating']); ?>
            </p>

            <p class="price">
                £<?php echo number_format($product['price'], 2); ?>
            </p>

            <p class="desc">
                <?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?>
            </p>

            <!-- EXTRA INFO -->
            <section class="extra-info">
                <h3 class="sr-only">Extra Information</h3>
                <p><strong>Age Range:</strong> <?php echo htmlspecialchars($product['age_range'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Stock:</strong> <?php echo htmlspecialchars($product['stock'], ENT_QUOTES, 'UTF-8'); ?></p>
            </section>

            <!-- LONG DESCRIPTION -->
            <section>
                <h3>Product Information</h3>
                <p><?php echo htmlspecialchars($product['long_description'], ENT_QUOTES, 'UTF-8'); ?></p>
            </section>

            <!-- ACTIONS -->
            <section class="actions">
                <h3 class="sr-only">Actions</h3>

                <?php if (isset($_SESSION['user']) && isset($_SESSION['user_id'])): ?>
                    <a href="cart.php?action=add&amp;id=<?php echo (int)$product['id']; ?>" class="btn-cart">
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