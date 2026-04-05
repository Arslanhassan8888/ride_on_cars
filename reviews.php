<?php
session_start();
require 'db.php';

/* --GET REVIEWS-- */
/* Retrieve latest reviews */
function getReviews($pdo)
{
    /* Fetch latest 9 reviews ordered by creation date */
    $stmt = $pdo->prepare("SELECT * FROM reviews ORDER BY created_at DESC LIMIT 9");
    /* Execute query and return results as an array */
    $stmt->execute();
    /* Fetch all reviews and return as associative array */
    return $stmt->fetchAll();
}

/* --STARS-- */
/* Convert rating into star symbols */
function stars($rating)
{
    return str_repeat("★", $rating);
}

/* --FETCH DATA-- */
$reviews = getReviews($pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reviews</title>
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/reviews.css?v=<?php echo filemtime('css/reviews.css'); ?>">
</head>

<body>

    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include 'header.php'; ?>

    <main id="main-content">

        <!-- HERO -->
        <section class="reviews-hero">
            <h1>Customer Reviews</h1>
            <p>See what families think about RideOn Kids.</p>

            <?php if (isset($_SESSION['user']) && isset($_SESSION['user_id'])): ?>
                <a href="add_review.php" class="btn-review">Leave a Review</a>
            <?php else: ?>
                <a href="login.php" class="btn-review">Login to Leave Review</a>
            <?php endif; ?>
        </section>

        <!-- REVIEWS GRID -->
        <section class="reviews-grid">
            <h2 class="visually-hidden-heading">Customer reviews list</h2>

            <?php foreach ($reviews as $review): ?>

                <article class="review-card">

                    <!-- STARS -->
                    <p class="stars">
                        <?= stars($review['rating']) ?>
                    </p>

                    <!-- MESSAGE -->
                    <p class="text">
                        <?= htmlspecialchars($review['message']) ?>
                    </p>

                    <!-- NAME -->
                    <h2><?= htmlspecialchars($review['name']) ?></h2>

                    <!-- LOCATION -->
                    <p class="location">
                        <?= htmlspecialchars($review['location']) ?>
                    </p>

                    <!-- DATE -->
                    <p class="date">
                        <?= date("d M Y", strtotime($review['created_at'])) ?>
                    </p>

                </article>

            <?php endforeach; ?>

        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>