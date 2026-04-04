<?php
session_start();
require 'db.php';

$error = "";
$success = "";

/* VALIDATE */
function validate($name, $email, $password, $confirm)
{
    if ($name == "" || $email == "" || $password == "" || $confirm == "") {
        return "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }

    if (strlen($password) < 6) {
        return "Password must be at least 6 characters.";
    }

    if ($password != $confirm) {
        return "Passwords do not match.";
    }

    return "";
}

/* CREATE USER */
function createUser($pdo, $name, $email, $password)
{
    $hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hash]);
        return "success";
    } catch (PDOException $e) {
        return "Email already exists.";
    }
}

/* HANDLE REGISTER */
function handleRegister($pdo)
{
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return ["", ""];
    }

    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password =($_POST['password']);   
    $confirm = htmlspecialchars($_POST['confirm']);   

    $error = validate($name, $email, $password, $confirm);

    if ($error != "") {
        return [$error, ""];
    }

    $result = createUser($pdo, $name, $email, $password);

    if ($result == "success") {
        header("refresh:2;url=login.php");
        return ["", "Account created successfully! Redirecting..."];
    }

    return [$result, ""];
}

/* RUN */
list($error, $success) = handleRegister($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/register.css?v=<?php echo filemtime('css/register.css'); ?>">
</head>
<body>

<?php include 'header.php'; ?>

<main>

<section class="register-hero">
    <h1>Create Account</h1>
    <p>Join Ride On Cars today</p>
</section>

<section class="register-container">
    <h2 class="register-title">Register</h2>

    <form method="POST">

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <label for="name">Full Name *</label>
        <input id="name" type="text" name="name"
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

        <label for="email">Email Address *</label>
        <input id="email" type="email" name="email"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

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