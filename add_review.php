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

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/reviews.css?v=<?php echo filemtime('css/reviews.css'); ?>">
</head>

<body>

    <?php include 'header.php'; ?>

    <main>

        <section class="reviews-hero">
            <h1>Leave a Review</h1>
            <p>Share your experience with RideOn Kids</p>
        </section>

        <section class="register-container">

            <form method="POST">

                <?php if ($error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <?php if ($success): ?>
                    <p class="success"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>

                <label>Name *</label>
                <input type="text" name="name" required>

                <label>Location *</label>
                <input type="text" name="location" required>

                <label>Rating *</label>
                <select name="rating" required>
                    <option value="">Select rating</option>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>

                <label>Your Review *</label>
                <textarea name="message" rows="4" required></textarea>

                <button type="submit">Submit Review</button>

            </form>

        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>