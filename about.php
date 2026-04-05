<?php
// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <!-- Main styles + page-specific styles -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/about.css?v=<?php echo filemtime('css/about.css'); ?>">
</head>

<body>

    <!-- Skip link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include 'header.php'; ?>

    <main id="main-content">

        <!-- Intro section -->
        <section class="about-hero">
            <h1>About RideOn Kids</h1>
            <p>
                Delivering safe, innovative and exciting ride-on experiences
                that bring joy to children and confidence to parents.
            </p>
        </section>

        <!-- Company story -->
        <section class="about-story">

            <!-- Hidden heading for accessibility -->
            <h2 class="visually-hidden-heading">About our story</h2>

            <!-- Text content -->
            <article class="story-text">
                <h2>Our Story</h2>

                <p>
                    RideOn Kids was founded in 2020 with a simple idea — to bring safe,
                    reliable and exciting ride-on cars to families across the UK. What
                    began as a small project quickly grew as more parents trusted our
                    products for their children.
                </p>

                <p>
                    From the beginning, our focus has always been on quality and safety.
                    Every vehicle is carefully selected and tested to ensure it meets
                    high standards, giving parents confidence and children a fun
                    experience.
                </p>

                <p>
                    We believe that toys are more than just products — they are part of
                    childhood memories. Whether it is a first drive around the garden
                    or a fun afternoon with friends, our ride-on cars are designed to
                    create moments that last.
                </p>

                <p>
                    As the business grew, so did our range. We introduced different
                    styles, from sporty cars to larger off-road vehicles, ensuring there
                    is something suitable for every age and preference.
                </p>

                <p>
                    Today, RideOn Kids continues to develop, focusing on innovation,
                    customer satisfaction, and long-term quality. We are proud to serve
                    families and remain committed to improving our products year after year.
                </p>
            </article>

            <!-- Supporting image -->
            <figure class="story-image">
                <img src="images/about.jpg" alt="Ride On Car">
            </figure>

        </section>

        <!-- Company values -->
        <section class="about-values">

            <header>
                <h2>Our Values</h2>
                <p>What defines our commitment every day</p>
            </header>

            <section class="values-grid">

                <!-- Hidden heading for structure -->
                <h3 class="visually-hidden-heading">Company values list</h3>

                <article class="card">
                    <h3>Safety</h3>
                    <p>Strict testing and safety standards for every product.</p>
                </article>

                <article class="card">
                    <h3>Quality</h3>
                    <p>Durable materials and reliable performance you can trust.</p>
                </article>

                <article class="card">
                    <h3>Joy</h3>
                    <p>Creating unforgettable moments for children and families.</p>
                </article>

                <article class="card">
                    <h3>Care</h3>
                    <p>Dedicated support before and after every purchase.</p>
                </article>

            </section>

        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>