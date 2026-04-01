<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    /* VALIDATION */
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {

        /* TEMP REGISTER */
        $_SESSION['user'] = $name;

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

<?php include 'header.php'; ?>

<main>

    <!-- HERO -->
    <section class="register-hero">
        <h1>Create Account</h1>
        <p>Join Ride On Cars today</p>
    </section>

    <!-- FORM -->
    <section class="register-container">

        <form method="POST">

            <?php if (!empty($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

            <label for="name">Full Name *</label>
            <input id="name" type="text" name="name" required>

            <label for="email">Email Address *</label>
            <input id="email" type="email" name="email" required>

            <label for="password">Password *</label>
            <input id="password" type="password" name="password" required>

            <label for="confirm">Confirm Password *</label>
            <input id="confirm" type="password" name="confirm" required>

            <button type="submit">Register</button>

            <p>
                Already have an account?
                <a href="login.php">Login here</a>
            </p>

        </form>

    </section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>