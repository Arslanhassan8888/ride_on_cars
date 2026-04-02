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

        <!-- LOGO / BRAND -->
        <a href="index.php" class="brand">
            <span class="logo">🚙</span>
            <span class="brand-name">Ride On Cars</span>
        </a>

        <!-- MOBILE MENU TOGGLE -->
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">☰</label>

        <!-- NAVIGATION -->
        <ul class="menu">
            <li><a href="index.php" class="<?php echo isActive('index.php'); ?>">Home</a></li>
            <li><a href="about.php" class="<?php echo isActive('about.php'); ?>">About</a></li>
            <li><a href="products.php" class="<?php echo isActive('products.php'); ?>">Products</a></li>
            <li><a href="contact.php" class="<?php echo isActive('contact.php'); ?>">Contact</a></li>
            <li><a href="reviews.php" class="<?php echo isActive('reviews.php'); ?>">Reviews</a></li>
        </ul>

        <!-- USER SECTION -->
        <aside class="user">

            <?php if (isset($_SESSION['user']) && isset($_SESSION['user_id'])): ?>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="admin.php" class="admin-link">Admin</a>
                <?php endif; ?>

                <span class="welcome">
                    Hi, <?php echo htmlspecialchars($_SESSION['user']); ?>
                </span>

                <a href="logout.php" class="logout">Logout</a>

                <?php
                $count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                ?>

                <a href="cart.php" class="cart">
                    Cart (<?php echo $count; ?>)
                </a>

            <?php else: ?>

                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
                <a href="login.php" class="cart disabled">Cart</a>

            <?php endif; ?>

        </aside>

    </nav>

</header>