<?php
session_start();

require 'db.php';

$error = "";
$success = "";

/* ================= FUNCTIONS ================= */

/* Clean input */
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

/* Validate register form */
function validateRegister($name, $email, $password, $confirm) {

    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        return "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }

    if (strlen($password) < 6) {
        return "Password must be at least 6 characters.";
    }

    if ($password !== $confirm) {
        return "Passwords do not match.";
    }

    return "";
}

/* Create user in DB */
function createUser($pdo, $name, $email, $password) {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);
        return "success";

    } catch (PDOException $e) {
        return "Email already exists.";
    }
}

/* ================= MAIN LOGIC ================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    $validationError = validateRegister($name, $email, $password, $confirm);

    if (!empty($validationError)) {
        $error = $validationError;
    } else {

        $result = createUser($pdo, $name, $email, $password);

        if ($result === "success") {
            $success = "Account created successfully! Redirecting...";
            header("refresh:2;url=login.php");
        } else {
            $error = $result;
        }
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

    <section class="register-hero">
        <h1>Create Account</h1>
        <p>Join Ride On Cars today</p>
    </section>

    <section class="register-container">

        <form method="POST">

            <?php if (!empty($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <p class="success"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <label for="name">Full Name *</label>
            <input id="name" type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

            <label for="email">Email Address *</label>
            <input id="email" type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

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