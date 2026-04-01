<?php
session_start();
require 'db.php';

// Get input
$search = trim($_GET['search'] ?? '');
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';
$sort = $_GET['sort'] ?? '';

// Function to get filtered products
function getFilteredProducts($pdo, $search, $min, $max, $sort) {

    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    // Search
    if (!empty($search)) {
        $sql .= " AND name LIKE ?";
        $params[] = "%$search%";
    }

    // Min price
    if (!empty($min)) {
        $sql .= " AND price >= ?";
        $params[] = (float)$min;
    }

    // Max price
    if (!empty($max)) {
        $sql .= " AND price <= ?";
        $params[] = (float)$max;
    }

    // Sort
    if (!empty($sort)) {
        if ($sort == "price_asc") {
            $sql .= " ORDER BY price ASC";
        } elseif ($sort == "price_desc") {
            $sql .= " ORDER BY price DESC";
        } elseif ($sort == "rating") {
            $sql .= " ORDER BY rating DESC";
        }
    }

    // Execute
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

// Function for stars
function renderStars($rating) {
    return str_repeat("★", (int)$rating);
}

// Get products
$products = getFilteredProducts($pdo, $search, $min, $max, $sort);
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

    <!-- Hero -->
    <section class="products-hero">
        <h1>Electric Ride-On Cars</h1>
        <p>Explore our collection of amazing ride-on cars for kids</p>
    </section>

    <!-- Filter -->
    <section class="filter-box">

        <form method="GET">

            <!-- Sort -->
            <label for="sort">Sort By</label>
            <select name="sort" id="sort">
                <option value="">Select</option>
                <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Price Low → High</option>
                <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Price High → Low</option>
                <option value="rating" <?= $sort == 'rating' ? 'selected' : '' ?>>Best Rating</option>
            </select>

            <!-- Price -->
            <label>Search by Price</label>
            <input type="number" name="min" placeholder="Min Price" value="<?= htmlspecialchars($min) ?>">
            <input type="number" name="max" placeholder="Max Price" value="<?= htmlspecialchars($max) ?>">

            <!-- Search -->
            <label for="search">Search by Name</label>
            <input type="text" name="search" placeholder="Type product name..." value="<?= htmlspecialchars($search) ?>">

            <!-- Buttons -->
            <button type="submit">Apply Filter</button>
            <a href="products.php" class="clear-btn">Clear Filters</a>

        </form>

    </section>

    <!-- Products -->
    <section class="products-grid">

        <!-- Empty -->
        <?php if (empty($products)): ?>
            <p>No products found.</p>
        <?php endif; ?>

        <!-- Loop -->
        <?php foreach ($products as $product): ?>

            <article class="product-card">

                <!-- Image -->
                <figure>
                    <img src="images/<?= htmlspecialchars($product['image']) ?>" 
                         alt="<?= htmlspecialchars($product['name']) ?>">
                </figure>

                <!-- Title -->
                <h2><?= htmlspecialchars($product['name']) ?></h2>

                <!-- Rating -->
                <p class="rating">
                    <?= renderStars($product['rating']) ?>
                </p>

                <!-- Description -->
                <p class="desc">
                    <?= htmlspecialchars($product['description']) ?>
                </p>

                <!-- Price -->
                <p class="price">
                    £<?= number_format($product['price'], 2) ?>
                </p>

                <!-- Actions -->
                <section class="actions">

                    <!-- Cart -->
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="cart.php?action=add&id=<?= $product['id'] ?>" class="btn-cart">
                            Add to Cart
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn-cart">
                            Login to Buy
                        </a>
                    <?php endif; ?>

                    <!-- Info -->
                    <a href="product_details.php?id=<?= $product['id'] ?>" class="btn-info">More Info</a>

                </section>

            </article>

        <?php endforeach; ?>

    </section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>