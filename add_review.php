<?php
session_start();
require 'db.php';

/* PROTECT PAGE */
if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

/* INSERT REVIEW */
function addReview($pdo, $user_id, $name, $location, $rating, $message)
{
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, name, location, rating, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $name, $location, $rating, $message]);
}

/* HANDLE FORM */
function handleReview($pdo)
{
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return ["", ""];
    }

    $name = htmlspecialchars(trim($_POST['name']));
    $location = htmlspecialchars(trim($_POST['location']));
    $rating = (int)$_POST['rating'];
    $message = htmlspecialchars(trim($_POST['message']));

    // VALIDATION
    if ($name == "" || $location == "" || $message == "") {
        return ["All fields are required.", ""];
    }

    if ($rating < 1 || $rating > 5) {
        return ["Invalid rating.", ""];
    }

    $user_id = $_SESSION['user_id'];
    addReview($pdo, $user_id, $name, $location, $rating, $message);

    return ["", "Review submitted successfully!"];
}

/* RUN */
list($error, $success) = handleReview($pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Review</title>
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/reviews.css?v=<?php echo filemtime('css/reviews.css'); ?>">
</head>

<body>

    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include 'header.php'; ?>

    <main id="main-content">



        <section class="reviews-hero">
            <h1>Leave a Review</h1>
            <p>Share your experience with RideOn Kids</p>
        </section>

        <section class="register-container">
            <h2 class="visually-hidden-heading">Review submission form</h2>

            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

                <?php if ($error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <?php if ($success): ?>
                    <p class="success"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>

                <label for="review-name">Name *</label>
                <input
                    type="text"
                    id="review-name"
                    name="name"
                    required
                    value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">

                <label for="review-location">Location *</label>
                <input
                    type="text"
                    id="review-location"
                    name="location"
                    required
                    value="<?= isset($_POST['location']) ? htmlspecialchars($_POST['location']) : '' ?>">

                <label for="review-rating">Rating *</label>
                <select id="review-rating" name="rating" required>
                    <option value="">Select rating</option>
                    <option value="5" <?= (isset($_POST['rating']) && $_POST['rating'] == '5') ? 'selected' : '' ?>>⭐⭐⭐⭐⭐</option>
                    <option value="4" <?= (isset($_POST['rating']) && $_POST['rating'] == '4') ? 'selected' : '' ?>>⭐⭐⭐⭐</option>
                    <option value="3" <?= (isset($_POST['rating']) && $_POST['rating'] == '3') ? 'selected' : '' ?>>⭐⭐⭐</option>
                    <option value="2" <?= (isset($_POST['rating']) && $_POST['rating'] == '2') ? 'selected' : '' ?>>⭐⭐</option>
                    <option value="1" <?= (isset($_POST['rating']) && $_POST['rating'] == '1') ? 'selected' : '' ?>>⭐</option>
                </select>

                <label for="review-message">Your Review *</label>
                <textarea
                    id="review-message"
                    name="message"
                    rows="4"
                    required><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?></textarea>

                <button type="submit" class="btn-review1">Submit Review</button>

            </form>

        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>