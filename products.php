<?php
session_start();
require 'db.php';

$search = trim($_GET['search'] ?? '');
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';
$sort = $_GET['sort'] ?? '';

function getProducts($pdo, $search, $min, $max, $sort)
{
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    if ($search !== '') {
        $sql .= " AND name LIKE ?";
        $params[] = "%$search%";
    }

    if ($min !== '') {
        $sql .= " AND price >= ?";
        $params[] = $min;
    }

    if ($max !== '') {
        $sql .= " AND price <= ?";
        $params[] = $max;
    }

    if ($sort === "price_asc") $sql .= " ORDER BY price ASC";
    if ($sort === "price_desc") $sql .= " ORDER BY price DESC";
    if ($sort === "rating") $sql .= " ORDER BY rating DESC";
    if ($sort === "name_asc") $sql .= " ORDER BY name ASC";
    if ($sort === "name_desc") $sql .= " ORDER BY name DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function stars($rating)
{
    return str_repeat("★", $rating);
}

function selected($value, $current)
{
    return $value == $current ? 'selected' : '';
}

$products = getProducts($pdo, $search, $min, $max, $sort);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/products.css?v=<?php echo filemtime('css/products.css'); ?>">
</head>

<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include 'header.php'; ?>

    <main id="main-content">

        <section class="products-hero">
            <h1>Electric Ride-On Cars</h1>
            <p>Explore our collection of amazing ride-on cars for kids</p>
        </section>

        <section class="filter-box">
            <h2 class="section-title">Product Filters</h2>
            <h2 class="visually-hidden">Filters</h2>

            <form method="GET">

                <label for="sort">Sort By</label>
                <select name="sort" id="sort">
                    <option value="">Select</option>
                    <option value="price_asc" <?= selected('price_asc', $sort) ?>>Price Low → High</option>
                    <option value="price_desc" <?= selected('price_desc', $sort) ?>>Price High → Low</option>
                    <option value="rating" <?= selected('rating', $sort) ?>>Best Rating</option>
                    <option value="name_asc" <?= selected('name_asc', $sort) ?>>Name A → Z</option>
                    <option value="name_desc" <?= selected('name_desc', $sort) ?>>Name Z → A</option>
                </select>

                <label for="min" class="visually-hidden">Minimum Price</label>
                <input type="number" id="min" name="min" placeholder="Min Price" value="<?= htmlspecialchars($min) ?>">

                <label for="max" class="visually-hidden">Maximum Price</label>
                <input type="number" id="max" name="max" placeholder="Max Price" value="<?= htmlspecialchars($max) ?>">

                <label for="search">Search by Name</label>
                <input type="text" id="search" name="search" placeholder="Type product name..." value="<?= htmlspecialchars($search) ?>">

                <button type="submit">Apply Filter</button>
                <a href="products.php" class="clear-btn">Clear Filters</a>

            </form>
        </section>

        <section class="products-list-section">
            <h2 class="section-title">Product List</h2>
            <h2 class="visually-hidden">Products</h2>

            <div class="products-grid">
                <?php if (empty($products)): ?>
                    <p>No products found.</p>
                <?php endif; ?>

                <?php foreach ($products as $product): ?>
                    <article class="product-card">

                        <figure>
                            <img src="images/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        </figure>

                        <h2><?= htmlspecialchars($product['name']) ?></h2>

                        <p class="rating"><?= stars($product['rating']) ?></p>

                        <p class="desc"><?= htmlspecialchars($product['description']) ?></p>

                        <p class="price">£<?= number_format($product['price'], 2) ?></p>

                        <section class="actions">
                            <h3 class="visually-hidden">Actions</h3>

                            <?php if (isset($_SESSION['user']) && isset($_SESSION['user_id'])): ?>
                                <a href="cart.php?action=add&id=<?= $product['id'] ?>" class="btn-cart">Add to Cart</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-cart">Login to Buy</a>
                            <?php endif; ?>

                            <a href="product_details.php?id=<?= $product['id'] ?>" class="btn-info">More Info</a>
                        </section>

                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

</body>

</html>