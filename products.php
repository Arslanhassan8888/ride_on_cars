<?php
session_start();
require 'db.php';

/* INPUT */
$search = trim($_GET['search'] ?? '');
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';
$sort = $_GET['sort'] ?? '';

/* GET PRODUCTS */
function getProducts($pdo, $search, $min, $max, $sort)
{
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    if ($search != '') {
        $sql .= " AND name LIKE ?";
        $params[] = "%$search%";
    }

    if ($min != '') {
        $sql .= " AND price >= ?";
        $params[] = $min;
    }

    if ($max != '') {
        $sql .= " AND price <= ?";
        $params[] = $max;
    }

    // Sorting (simple if style)
    if ($sort == "price_asc") {
        $sql .= " ORDER BY price ASC";
    }

    if ($sort == "price_desc") {
        $sql .= " ORDER BY price DESC";
    }

    if ($sort == "rating") {
        $sql .= " ORDER BY rating DESC";
    }

    if ($sort == "name_asc") {
        $sql .= " ORDER BY name ASC";
    }

    if ($sort == "name_desc") {
        $sql .= " ORDER BY name DESC";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}

/* STARS */
function stars($rating)
{
    return str_repeat("★", $rating);
}

/* HELPER FOR SELECT */
function selected($value, $current)
{
    return $value == $current ? 'selected' : '';
}

/* DATA */
$products = getProducts($pdo, $search, $min, $max, $sort);
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

<section class="products-hero">
    <h1>Electric Ride-On Cars</h1>
    <p>Explore our collection of amazing ride-on cars for kids</p>
</section>

<section class="filter-box">

    <form method="GET">

        <label for="sort">Sort By</label>
        <select name="sort" id="sort">
            <option value="">Select</option>

            <option value="price_asc" <?= selected('price_asc', $sort) ?>>
                Price Low → High
            </option>

            <option value="price_desc" <?= selected('price_desc', $sort) ?>>
                Price High → Low
            </option>

            <option value="rating" <?= selected('rating', $sort) ?>>
                Best Rating
            </option>

            <option value="name_asc" <?= selected('name_asc', $sort) ?>>
                Name A → Z
            </option>

            <option value="name_desc" <?= selected('name_desc', $sort) ?>>
                Name Z → A
            </option>
        </select>

        <label>Search by Price</label>
        <input type="number" name="min" placeholder="Min Price" value="<?= $min ?>">
        <input type="number" name="max" placeholder="Max Price" value="<?= $max ?>">

        <label for="search">Search by Name</label>
        <input type="text" name="search" placeholder="Type product name..." value="<?= htmlspecialchars($search) ?>">

        <button type="submit">Apply Filter</button>
        <a href="products.php" class="clear-btn">Clear Filters</a>

    </form>

</section>

<section class="products-grid">

    <?php if (empty($products)): ?>
        <p>No products found.</p>
    <?php endif; ?>

    <?php foreach ($products as $product): ?>

    <article class="product-card">

        <figure>
            <img src="images/<?= $product['image'] ?>" 
                 alt="<?= htmlspecialchars($product['name']) ?>">
        </figure>

        <h2><?= htmlspecialchars($product['name']) ?></h2>

        <p class="rating">
            <?= stars($product['rating']) ?>
        </p>

        <p class="desc">
            <?= htmlspecialchars($product['description']) ?>
        </p>

        <p class="price">
            £<?= number_format($product['price'], 2) ?>
        </p>

        <section class="actions">

            <?php if (isset($_SESSION['user'])): ?>
                <a href="cart.php?action=add&id=<?= $product['id'] ?>" class="btn-cart">
                    Add to Cart
                </a>
            <?php else: ?>
                <a href="login.php" class="btn-cart">
                    Login to Buy
                </a>
            <?php endif; ?>

            <a href="product_details.php?id=<?= $product['id'] ?>" class="btn-info">
                More Info
            </a>

        </section>

    </article>

    <?php endforeach; ?>

</section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>