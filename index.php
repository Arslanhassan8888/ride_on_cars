<!-- index.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ride On Cars</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <!-- Stylesheets (cache-busted using file modification time) -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/index.css?v=<?php echo filemtime('css/index.css'); ?>">
</head>

<body>

    <!-- Accessibility: Skip link for keyboard and screen reader users -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Site header -->
    <?php include 'header.php'; ?>

    <!-- Main content area -->
    <main id="main-content">

        <!-- HERO SECTION -->
        <section class="hero">
            <h1>Welcome to Ride On Cars</h1>
            <p>Discover fun and safe cars for kids.</p>

            <!-- Call-to-action button -->
            <a href="products.php" class="btn">View Products</a>
        </section>

        <!-- FEATURES SECTION -->
        <section class="features">

            <!-- Hidden heading for accessibility (screen readers only) -->
            <h2 class="sr-only">Features</h2>

            <!-- Feature: Safety -->
            <article>
                <h3>Safe</h3>
                <p>All cars are tested for safety.</p>
            </article>

            <!-- Feature: Affordability -->
            <article>
                <h3>Affordable</h3>
                <p>Best prices for high quality.</p>
            </article>

            <!-- Feature: Enjoyment -->
            <article>
                <h3>Fun</h3>
                <p>Kids love our products.</p>
            </article>

        </section>

    </main>

    <!-- Site footer -->
    <?php include 'footer.php'; ?>

</body>
</html>