<?php
session_start();
require 'db.php';

/*
    Retrieve filter values from the URL (GET request).
    These are optional, so defaults are empty values.
*/
$search = trim($_GET['search'] ?? '');
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';
$sort = $_GET['sort'] ?? '';

/*
    Build SQL query dynamically based on user filters.

    - Uses prepared statements to prevent SQL injection
    - Conditions are only added if the user provides input
*/
function getProducts($pdo, $search, $min, $max, $sort)
{
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    // Search by product name
    if ($search !== '') {
        $sql .= " AND name LIKE ?";
        $params[] = "%$search%";
    }

    // Filter by minimum price
    if ($min !== '') {
        $sql .= " AND price >= ?";
        $params[] = $min;
    }

    // Filter by maximum price
    if ($max !== '') {
        $sql .= " AND price <= ?";
        $params[] = $max;
    }

    // Sorting options
    if ($sort === "price_asc") $sql .= " ORDER BY price ASC";
    if ($sort === "price_desc") $sql .= " ORDER BY price DESC";
    if ($sort === "rating") $sql .= " ORDER BY rating DESC";
    if ($sort === "name_asc") $sql .= " ORDER BY name ASC";
    if ($sort === "name_desc") $sql .= " ORDER BY name DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

/*
    Convert numeric rating into star symbols.
    Example: 4 → ★★★★
*/
function stars($rating)
{
    return str_repeat("★", (int)$rating);
}

/*
    Keep selected option after form submission.
*/
function selected($value, $current)
{
    return $value == $current ? 'selected' : '';
}

/* Fetch filtered products */
$products = getProducts($pdo, $search, $min, $max, $sort);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Browse electric ride-on cars for kids, compare prices, ratings and features, and find the perfect model for your child.">
    <title>Products</title>

    <!-- Website icon -->
    <link rel="icon" href="images/car_logo.png">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/products.css?v=<?php echo filemtime('css/products.css'); ?>">
</head>

<body>

    <!-- Accessibility: skip navigation -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include 'header.php'; ?>

    <main id="main-content" tabindex="-1">

        <!-- Page introduction -->
        <section class="products-hero">
            <h1>Electric Ride-On Cars</h1>
            <p>Explore our collection of amazing ride-on cars for kids</p>
        </section>

        <!-- Filter form -->
        <section class="filter-box">

            <!-- Visible heading -->
            <h2 class="section-title">Product Filters</h2>

            <!-- Hidden heading for screen readers -->
            <h2 class="visually-hidden">Filters</h2>

            <!-- Filter form (GET request) -->
            <form method="GET">

                <!-- Sorting -->
                <label for="sort">Sort By</label>
                <select name="sort" id="sort">
                    <option value="">Select</option>
                    <option value="price_asc" <?= selected('price_asc', $sort) ?>>Price Low → High</option>
                    <option value="price_desc" <?= selected('price_desc', $sort) ?>>Price High → Low</option>
                    <option value="rating" <?= selected('rating', $sort) ?>>Best Rating</option>
                    <option value="name_asc" <?= selected('name_asc', $sort) ?>>Name A → Z</option>
                    <option value="name_desc" <?= selected('name_desc', $sort) ?>>Name Z → A</option>
                </select>

                <!-- Price filters -->
                <label for="min" class="visually-hidden">Minimum price</label>
                <input id="min" type="number" name="min" placeholder="Min Price" value="<?= htmlspecialchars($min) ?>">

                <label for="max" class="visually-hidden">Maximum price</label>
                <input id="max" type="number" name="max" placeholder="Max Price" value="<?= htmlspecialchars($max) ?>">

                <!-- Search -->
                <label for="search" class="visually-hidden">Search products</label>
                <input id="search" type="text" name="search" placeholder="Type product name..." value="<?= htmlspecialchars($search) ?>">

                <!-- Actions -->
                <button type="submit">Apply Filter</button>
                <a href="products.php" class="clear-btn">Clear Filters</a>

            </form>
        </section>

        <!-- Product listing -->
        <section class="products-list-section">

            <h2 class="section-title">Product List</h2>
            <h2 class="visually-hidden">Products</h2>

            <div class="products-grid">

                <!-- No results message -->
                <?php if (empty($products)): ?>
                    <p aria-live="polite">No products found.</p>
                <?php endif; ?>

                <!-- Loop through products -->
                <?php foreach ($products as $product): ?>
                    <article class="product-card">

                        <!-- Product image -->
                        <figure>
                            <img src="images/<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>">
                        </figure>

                        <!-- Product name -->
                        <h2><?= htmlspecialchars($product['name']) ?></h2>

                        <!-- Rating -->
                        <p class="rating">
                            <span class="visually-hidden"><?= (int)$product['rating'] ?> out of 5 stars</span>
                            <span aria-hidden="true"><?= stars($product['rating']) ?></span>
                        </p>

                        <!-- Short description -->
                        <p class="desc"><?= htmlspecialchars($product['description']) ?></p>

                        <!-- Price -->
                        <p class="price">£<?= number_format($product['price'], 2) ?></p>

                        <!-- Actions -->
                        <section class="actions">

                            <h3 class="visually-hidden">Actions</h3>

                            <?php if (isset($_SESSION['user']) && isset($_SESSION['user_id'])): ?>
                                <!-- Add to cart -->
                                <a href="cart.php?action=add&id=<?= (int)$product['id'] ?>" class="btn-cart">
                                    Add to Cart
                                </a>
                            <?php else: ?>
                                <!-- Require login -->
                                <a href="login.php" class="btn-cart">
                                    Login to Buy
                                </a>
                            <?php endif; ?>

                            <!-- Link to details page -->
                            <a href="product_details.php?id=<?= (int)$product['id'] ?>" class="btn-info">
                                View <?= htmlspecialchars($product['name']) ?>
                            </a>

                        </section>

                    </article>
                <?php endforeach; ?>

            </div>

        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>