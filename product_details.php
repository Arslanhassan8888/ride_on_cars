<?php
session_start();
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
    return str_repeat("★", $rating);
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
    <title><?= htmlspecialchars($product['name']) ?></title>

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/product_details.css?v=<?php echo filemtime('css/product_details.css'); ?>">
    
</head>

<body>

    <?php include 'header.php'; ?>

    <main>

        <section class="product-details">

            <!-- IMAGE -->
            <figure class="product-image">
                <img src="images/<?= $product['image'] ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>">
            </figure>

            <!-- INFO -->
            <section class="product-info">

                <h1><?= htmlspecialchars($product['name']) ?></h1>

                <p class="rating">
                    <?= stars($product['rating']) ?>
                </p>

                <p class="price">
                    £<?= number_format($product['price'], 2) ?>
                </p>

                <p class="desc">
                    <?= htmlspecialchars($product['description']) ?>
                </p>

                <!-- EXTRA INFO -->
                <section class="extra-info">
                    <p><strong>Age Range:</strong> <?= $product['age_range'] ?></p>
                    <p><strong>Stock:</strong> <?= $product['stock'] ?></p>
                </section>

                <!-- LONG DESCRIPTION -->
                <section>
                    <h2>Product Information</h2>
                    <p><?= htmlspecialchars($product['long_description']) ?></p>
                </section>

                <!-- ACTIONS -->
                <section class="actions">

                    <?php if (isset($_SESSION['user']) && isset($_SESSION['user_id'])): ?>
                        <a href="cart.php?action=add&id=<?= $product['id'] ?>" class="btn-cart">
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