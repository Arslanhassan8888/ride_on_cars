<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About</title>
    <link rel="icon" type="image/png" href="images/car_logo.png">


    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/about.css?v=<?php echo filemtime('css/about.css'); ?>">
</head>

<body>

<?php include 'header.php'; ?>

<main>

<!-- HERO -->
<section class="about-hero">
    <h1>About RideOn Kids</h1>
    <p>
        Delivering safe, innovative and exciting ride-on experiences
        that bring joy to children and confidence to parents.
    </p>
</section>

<!-- STORY -->
<section class="about-story">

    <article class="story-text">
        <h2>Our Story</h2>

        <p>
            RideOn Kids was founded in 2020 with a clear vision:
            to create high-quality electric ride-on cars that combine
            fun, safety, and durability. What started as a small idea
            quickly grew into a trusted brand for families across the UK.
        </p>

        <p>
            From the very beginning, our focus has been on delivering
            products that children love and parents can rely on. Every
            ride-on car is carefully selected, tested, and designed to
            meet strict safety standards while offering an exciting
            driving experience.
        </p>

        <p>
            We understand that toys are more than just products — they
            are part of childhood memories. That’s why we pay attention
            to every detail, from design and performance to comfort and
            ease of use.
        </p>

        <p>
            Over the years, our collection has expanded to include a wide
            range of vehicles — from luxury sports cars to rugged SUVs —
            ensuring there is something perfect for every child.
        </p>

        <p>
            Today, RideOn Kids continues to grow, proudly serving thousands
            of families and building a reputation for quality, trust, and
            excellent customer experience.
        </p>
    </article>

    <figure class="story-image">
        <img src="images/about.jpg" alt="Ride On Car">
    </figure>

</section>

<!-- VALUES -->
<section class="about-values">

    <header>
        <h2>Our Values</h2>
        <p>What defines our commitment every day</p>
    </header>

    <section class="values-grid">

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