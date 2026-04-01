<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['user'] = $_POST['email'];
    header("Location: index.php");
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

        <!-- FORM -->
        <section class="login-container">

            <form method="POST">

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