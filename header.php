<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* BASE PATH (AUTO FIX FOR ADMIN + ROOT) */
$base = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';

/* ACTIVE PAGE */
function isActive($file)
{
    return basename($_SERVER['PHP_SELF']) == $file ? 'active' : '';
}
?>

<header class="site-header">

    <nav class="nav-bar">

        <!-- LOGO / BRAND -->
        <a href="<?php echo $base; ?>index.php" class="brand">
            <span class="logo">🚙</span>
            <span class="brand-name">Ride On Cars</span>
        </a>

        <!-- MOBILE MENU TOGGLE -->
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">☰</label>

        <!-- NAVIGATION -->
        <ul class="menu">
            <li><a href="<?php echo $base; ?>index.php" class="<?php echo isActive('index.php'); ?>">Home</a></li>
            <li><a href="<?php echo $base; ?>about.php" class="<?php echo isActive('about.php'); ?>">About</a></li>
            <li><a href="<?php echo $base; ?>products.php" class="<?php echo isActive('products.php'); ?>">Products</a></li>
            <li><a href="<?php echo $base; ?>contact.php" class="<?php echo isActive('contact.php'); ?>">Contact</a></li>
            <li><a href="<?php echo $base; ?>reviews.php" class="<?php echo isActive('reviews.php'); ?>">Reviews</a></li>
        </ul>

        <!-- USER SECTION -->
        <aside class="user">

            <?php if (isset($_SESSION['user']) && isset($_SESSION['user_id'])): ?>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="<?php echo $base; ?>admin/dashboard.php" class="admin-link">Admin</a>
                <?php endif; ?>

                <span class="welcome">
                    Hi, <?php echo htmlspecialchars($_SESSION['user']); ?>
                </span>

                <a href="<?php echo $base; ?>logout.php" class="logout">Logout</a>

                <?php
                $count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                ?>

                <a href="<?php echo $base; ?>cart.php" class="cart">
                    Cart (<?php echo $count; ?>)
                </a>

            <?php else: ?>

                <a href="<?php echo $base; ?>login.php">Login</a>
                <a href="<?php echo $base; ?>register.php">Register</a>
                <a href="<?php echo $base; ?>login.php" class="cart disabled">Cart</a>

            <?php endif; ?>

        </aside>

    </nav>

</header>