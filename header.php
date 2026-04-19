<?php

/* Start session if not already active */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Determine base path (supports admin directory) 
 this allows for proper linking in both root and admin directories */
$base = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';

/**
 * Returns 'active' class if current page matches
 * Used for highlighting active menu item
 */
function isActive($file)
{
    return basename($_SERVER['PHP_SELF']) === $file ? 'active' : '';
}

/* Check user state */
$isLoggedIn = isset($_SESSION['user'], $_SESSION['user_id']);
/* Check if user is admin */
$isAdmin = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

/* Calculate cart item count */
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>


<header class="site-header">

    <nav class="nav-bar" aria-label="Main navigation">

        <!-- BRAND / LOGO -->
        <a href="<?php echo $base; ?>index.php" class="brand">
            <span class="logo">🚙</span>
            <span class="brand-name">Ride On Cars</span>
        </a>

        <!-- MOBILE MENU TOGGLE -->
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">
            <span aria-hidden="true">☰</span>
            <span class="visually-hidden">Open menu</span>
        </label>

        <!-- MAIN NAVIGATION -->
        <ul class="menu">
            <li><a href="<?php echo $base; ?>index.php" class="<?php echo isActive('index.php'); ?>">Home</a></li>
            <li><a href="<?php echo $base; ?>about.php" class="<?php echo isActive('about.php'); ?>">About</a></li>
            <li><a href="<?php echo $base; ?>products.php" class="<?php echo isActive('products.php'); ?>">Products</a></li>
            <li><a href="<?php echo $base; ?>contact.php" class="<?php echo isActive('contact.php'); ?>">Contact</a></li>
            <li><a href="<?php echo $base; ?>reviews.php" class="<?php echo isActive('reviews.php'); ?>">Reviews</a></li>
        </ul>

        <!-- USER SECTION -->
        <aside class="user">

            <?php if ($isLoggedIn): ?>

                <!-- Admin access (only visible to admin users) -->
                <?php if ($isAdmin): ?>
                    <a href="<?php echo $base; ?>admin/dashboard.php" class="admin-link">Admin</a>
                <?php endif; ?>

                <!-- Welcome message -->
                <span class="welcome">
                    Hi, <?php echo htmlspecialchars($_SESSION['user']); ?>
                </span>

                <!-- Logout -->
                <a href="<?php echo $base; ?>logout.php" class="logout">Logout</a>

                <!-- Cart -->
                <a href="<?php echo $base; ?>cart.php" class="cart">
                    Cart (<?php echo $cartCount; ?>)
                </a>

            <?php else: ?>

                <!-- Guest links -->
                <a href="<?php echo $base; ?>login.php">Login</a>
                <a href="<?php echo $base; ?>register.php">Register</a>

                <!-- Disabled cart (requires login) -->
                <a href="<?php echo $base; ?>login.php" class="cart disabled">Cart</a>

            <?php endif; ?>

        </aside>

    </nav>

</header>