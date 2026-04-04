<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ride On Cars</title>
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/index.css?v=<?php echo filemtime('css/index.css'); ?>">
</head>

<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include 'header.php'; ?>

    <main id="main-content">

        <section class="hero">
            <h1>Welcome to Ride On Cars</h1>
            <p>Discover fun and safe cars for kids.</p>
            <a href="products.php" class="btn">View Products</a>
        </section>

        <section class="features">
            <h2>
                <span class="sr-only">Feauter</span>
            </h2>

            <article>
                <h3>Safe</h3>
                <p>All cars are tested for safety.</p>
            </article>

            <article>
                <h3>Affordable</h3>
                <p>Best prices for high quality.</p>
            </article>

            <article>
                <h3>Fun</h3>
                <p>Kids love our products.</p>
            </article>
        </section>

    </main>

    <?php include 'footer.php'; ?>


</html>