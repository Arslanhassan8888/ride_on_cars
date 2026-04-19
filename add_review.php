<?php
session_start();
require 'db.php';

/* --ACCESS CONTROL-- */
/* Only logged-in users can submit reviews */
if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


/* --STATE VARIABLES-- */
$error = "";
$success = "";


/* --ADD REVIEW FUNCTION-- */
/* Inserts a new review into the database */
function addReview($pdo, $user_id, $name, $location, $rating, $message)
{   /* Prepare and execute the insert statement */
    $stmt = $pdo->prepare("
        INSERT INTO reviews (user_id, name, location, rating, message)
        VALUES (?, ?, ?, ?, ?)
    ");
    /* Execute with provided parameters */
    $stmt->execute([$user_id, $name, $location, $rating, $message]);
}


/* --FORM HANDLER-- */
/* Handles validation, sanitisation and submission */
function handleReview($pdo)
{
    /* Only run when form is submitted */
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return ["", ""];
    }

    /* --INPUT PROCESSING-- */
    $name = htmlspecialchars(trim($_POST['name']));
    $location = htmlspecialchars(trim($_POST['location']));
    $rating = (int)$_POST['rating'];
    $message = htmlspecialchars(trim($_POST['message']));

    /* --VALIDATION-- */
    /* Check for empty fields and valid rating */
    if ($name == "" || $location == "" || $message == "") {
        return ["All fields are required.", ""];
    }/* Validate rating is between 1 and 5 */
    if ($name == "" || $location == "" || $message == "") {
        return ["All fields are required.", ""];
    }
    /* Validate rating is between 1 and 5 */
    if ($rating < 1 || $rating > 5) {
        return ["Invalid rating.", ""];
    }

    /* --DATABASE INSERT-- */
    /* Get user ID from session and add review to database */
    /* Get user ID from session and add review to database */
    $user_id = $_SESSION['user_id'];
    addReview($pdo, $user_id, $name, $location, $rating, $message);
    /* Return success message */
    return ["", "Review submitted successfully!"];
}


/* --RUN HANDLER-- */
/* Handle review submission and capture any error or success messages */
list($error, $success) = handleReview($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Review</title>

    <link rel="icon" href="images/car_logo.png">

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/reviews.css?v=<?php echo filemtime('css/reviews.css'); ?>">
</head>

<body>

    <!-- Skip link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include 'header.php'; ?>

    <main id="main-content">

        <!-- HERO -->
        <section class="reviews-hero">
            <h1>Leave a Review</h1>
            <p>Share your experience with RideOn Kids</p>
        </section>

        <!-- FORM CONTAINER -->
        <section class="register-container">

            <h2 class="visually-hidden-heading">Review submission form</h2>

            <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

                <!-- ERROR MESSAGE -->
                <?php if ($error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <!-- SUCCESS MESSAGE -->
                <?php if ($success): ?>
                    <p class="success"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>

                <!-- NAME -->
                <label for="review-name">Name *</label>
                <input type="text" id="review-name" name="name" required
                    value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">

                <!-- LOCATION -->
                <label for="review-location">Location *</label>
                <input type="text" id="review-location" name="location" required
                    value="<?= isset($_POST['location']) ? htmlspecialchars($_POST['location']) : '' ?>">

                <!-- RATING -->
                <label for="review-rating">Rating *</label>
                <select id="review-rating" name="rating" required>
                    <option value="">Select rating</option>
                    <option value="5" <?= (isset($_POST['rating']) && $_POST['rating'] == '5') ? 'selected' : '' ?>>⭐⭐⭐⭐⭐</option>
                    <option value="4" <?= (isset($_POST['rating']) && $_POST['rating'] == '4') ? 'selected' : '' ?>>⭐⭐⭐⭐</option>
                    <option value="3" <?= (isset($_POST['rating']) && $_POST['rating'] == '3') ? 'selected' : '' ?>>⭐⭐⭐</option>
                    <option value="2" <?= (isset($_POST['rating']) && $_POST['rating'] == '2') ? 'selected' : '' ?>>⭐⭐</option>
                    <option value="1" <?= (isset($_POST['rating']) && $_POST['rating'] == '1') ? 'selected' : '' ?>>⭐</option>
                </select>

                <!-- MESSAGE -->
                <label for="review-message">Your Review *</label>
                <textarea id="review-message" name="message" rows="4" required>
                <?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?>
                </textarea>

                <!-- SUBMIT -->
                <button type="submit" class="btn-review1">Submit Review</button>

            </form>

        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>