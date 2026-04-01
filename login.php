<?php
session_start();

require 'db.php';

$error = "";

/* ================= FUNCTIONS ================= */

function sanitizeInput($data)
{
    return htmlspecialchars(trim($data));
}

function validateLogin($email, $password)
{
    if (empty($email) || empty($password)) {
        return "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }

    return "";
}

function loginUser($pdo, $email, $password)
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}

/* ================= ATTEMPTS ================= */

if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

if (!isset($_SESSION['blocked_time'])) {
    $_SESSION['blocked_time'] = 0;
}

/* ================= LOGIN ================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* CHECK IF BLOCKED */
    if ($_SESSION['blocked_time'] > time()) {
        $remaining = $_SESSION['blocked_time'] - time();
        $error = "Account blocked. Try again in $remaining seconds.";
    } else {

        $email = sanitizeInput($_POST['email']);
        $password = trim($_POST['password']);

        $validationError = validateLogin($email, $password);

        if (!empty($validationError)) {
            $error = $validationError;
        } else {

            $user = loginUser($pdo, $email, $password);

            if ($user) {

                /* SUCCESS */
                session_regenerate_id(true);

                $_SESSION['user'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                /* RESET ATTEMPTS */
                $_SESSION['attempts'] = 0;

                header("Location: index.php");
                exit();
            } else {

                $_SESSION['attempts']++;

                if ($_SESSION['attempts'] >= 3) {
                    $_SESSION['blocked_time'] = time() + (5 * 60); // 5 minutes
                    $error = "Too many attempts. Blocked for 5 minutes.";
                } else {
                    $error = "Invalid login. Attempts left: " . (3 - $_SESSION['attempts']);
                }
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
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <label for="email">Email Address *</label>
                <input id="email" type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

                <label for="password">Password *</label>
                <input id="password" type="password" name="password" required>

                <button type="submit">Login</button>

                <p>
                    Don’t have an account?
                    <a href="register.php">Register here</a>
                </p>

            </form>

        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>