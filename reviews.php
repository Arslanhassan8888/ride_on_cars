<?php
session_start();
require 'db.php';

/* GET REVIEWS */
function getReviews($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM reviews ORDER BY created_at DESC LIMIT 9");
    $stmt->execute();
    return $stmt->fetchAll();
}

/* STARS */
function stars($rating)
{
    return str_repeat("★", $rating);
}

/* DATA */
$reviews = getReviews($pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reviews</title>

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/reviews.css?v=<?php echo filemtime('css/reviews.css'); ?>">
</head>

<body>

<?php include 'header.php'; ?>

<main>

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

<!-- REVIEWS -->
<section class="reviews-grid">

    <?php foreach ($reviews as $review): ?>

    <article class="review-card">

        <p class="stars">
            <?= stars($review['rating']) ?>
        </p>

        <p class="text">
            <?= htmlspecialchars($review['message']) ?>
        </p>

        <h3><?= htmlspecialchars($review['name']) ?></h3>

        <p class="location">
            <?= htmlspecialchars($review['location']) ?>
        </p>

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