<header class="site-header">

    <nav class="nav-bar">

        <section class="brand">
            <span class="logo">🚙</span>
            <a href="index.php" class="brand-name">Ride On Cars</a>
        </section>

        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">☰</label>

        <?php $page = basename($_SERVER['PHP_SELF']); ?>

        <ul class="menu">
            <li><a href="index.php" class="<?= $page == 'index.php' ? 'active' : '' ?>">Home</a></li>
            <li><a href="about.php" class="<?= $page == 'about.php' ? 'active' : '' ?>">About</a></li>
            <li><a href="products.php" class="<?= $page == 'products.php' ? 'active' : '' ?>">Products</a></li>
            <li><a href="contact.php" class="<?= $page == 'contact.php' ? 'active' : '' ?>">Contact</a></li>
            <li><a href="reviews.php" class="<?= $page == 'reviews.php' ? 'active' : '' ?>">Reviews</a></li>
            </ul>

            <aside class="user">
                <a href="#">Login</a>
                <a href="#">Register</a>
                <a href="#">Logout</a>
                <a href="#" class="cart">Cart</a>
            </aside>

    </nav>

</header>