<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ACTIVE PAGE */
function isActive($file)
{
    return basename($_SERVER['PHP_SELF']) == $file ? 'active' : '';
}
?>

<header class="site-header">

    <nav class="nav-bar">

        <section class="brand">
            <span class="logo">🚙</span>
            <a href="index.php" class="brand-name">Ride On Cars</a>
        </section>

        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">☰</label>

        <ul class="menu">
            <li><a href="index.php" class="<?= isActive('index.php') ?>">Home</a></li>
            <li><a href="about.php" class="<?= isActive('about.php') ?>">About</a></li>
            <li><a href="products.php" class="<?= isActive('products.php') ?>">Products</a></li>
            <li><a href="contact.php" class="<?= isActive('contact.php') ?>">Contact</a></li>
            <li><a href="reviews.php" class="<?= isActive('reviews.php') ?>">Reviews</a></li>
        </ul>

        <aside class="user">

            <?php if (isset($_SESSION['user'])): ?>

                <span>Hi, <?= htmlspecialchars($_SESSION['user']) ?></span>
                <a href="logout.php">Logout</a>

                <a href="cart.php" class="cart">Cart</a>

            <?php else: ?>

                <a href="login.php">Login</a>
                <a href="register.php">Register</a>

                <a href="login.php" class="cart disabled">Cart</a>

            <?php endif; ?>

        </aside>

    </nav>

</header>