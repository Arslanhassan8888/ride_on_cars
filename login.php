<?php
session_start();

$error = "";

/* ================= ATTEMPTS ================= */
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

if (!isset($_SESSION['blocked_time'])) {
    $_SESSION['blocked_time'] = 0;
}

/* ================= CHECK BLOCK ================= */
if ($_SESSION['blocked_time'] > time()) {
    $remaining = $_SESSION['blocked_time'] - time();
    $error = "Account blocked. Try again in $remaining seconds.";
}

/* ================= LOGIN ================= */
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['blocked_time'] <= time()) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    /* VALIDATION */
    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {

        /* TEST LOGIN (TEMPORARY) */
        if ($email === "admin@test.com" && $password === "1234") {

            $_SESSION['user'] = $email;

            /* RESET ATTEMPTS */
            $_SESSION['attempts'] = 0;

            header("Location: index.php");
            exit();

        } else {

            $_SESSION['attempts']++;

            if ($_SESSION['attempts'] >= 3) {
                $_SESSION['blocked_time'] = time() + (5 * 60); // 5 min
                $error = "Too many attempts. Account blocked for 5 minutes.";
            } else {
                $error = "Invalid login. Attempts left: " . (3 - $_SESSION['attempts']);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<?php include 'header.php'; ?>

<main>

    <!-- HERO -->
    <section class="login-hero">
        <h1>Welcome Back!</h1>
        <p>Login to access your account</p>
    </section>

    <!-- LOGIN FORM -->
    <section class="login-container">

        <form method="POST">

            <?php if (!empty($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

            <label for="email">Email Address *</label>
            <input id="email" type="email" name="email" required>

            <label for="password">Password *</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Login</button>

            <p>
                Don’t have an account?
                <a href="#">Register here</a>
            </p>

        </form>

    </section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>