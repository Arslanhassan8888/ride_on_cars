<?php
session_start();
require 'db.php';

/* --STATE-- */
$error = "";
$success = "";

/* --VALIDATE-- */
/* Validates registration inputs and returns error message if invalid */
function validate($name, $email, $password, $confirm)
{   /* Check for empty fields */
    if ($name == "" || $email == "" || $password == "" || $confirm == "") {
        return "All fields are required.";
    }/* Validate email format */
    if ($name == "" || $email == "" || $password == "" || $confirm == "") {
        return "All fields are required.";
    }
    /* Validate email format */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    /* Validate password length */
    if (strlen($password) < 6) {
        return "Password must be at least 6 characters.";
    }/* Validate password confirmation */
    if (strlen($password) < 6) {
        return "Password must be at least 6 characters.";
    }
    /* Validate password confirmation */
    if ($password != $confirm) {
        return "Passwords do not match.";
    }
    /* If all validations pass, return empty error */
    return "";
}

/* --CREATE USER-- */
/* Creates a new user in the database and returns result message */
function createUser($pdo, $name, $email, $password)
{   /* Hash the password securely before storing */
    $hash = password_hash($password, PASSWORD_DEFAULT);
    /* Prepare and execute insert statement, handling duplicate email error */
    try {
        /* Prepare and execute the insert statement */
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hash]);
        return "success";
        /* Return success message if user is created successfully */
    } catch (PDOException $e) {
        return "Email already exists.";
    }
}

/* --HANDLE REGISTER-- */
/* Handles the registration form submission, validation and user creation */
function handleRegister($pdo)
{   /* Only run when form is submitted */
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return ["", ""];
    }
    /* Process and sanitize inputs */
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = ($_POST['password']);
    $confirm = htmlspecialchars($_POST['confirm']);
    /* Validate inputs and return error if invalid */
    $error = validate($name, $email, $password, $confirm);
    /* If validation fails, return error message */
    if ($error != "") {
        return ["", ""];
    }/* Create user and return success or error message */
    if ($error != "") {
        return [$error, ""];
    }
    /* Create user and return success or error message */
    $result = createUser($pdo, $name, $email, $password);
    /* If user creation is successful, return success message and redirect to login */
    if ($result == "success") {
        header("refresh:2;url=login.php");
        return ["", "Account created successfully! Redirecting..."];
    }
    /* If user creation fails, return error message */
    return [$result, ""];
}

/* --RUN-- */
/* Handle registration and capture any error or success messages */
list($error, $success) = handleRegister($pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="UTF-8">
    <title>Register</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <!-- STYLES -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/register.css?v=<?php echo filemtime('css/register.css'); ?>">
</head>

<body>

    <!-- SKIP LINK -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <!-- MAIN -->
    <main id="main-content">

        <!-- HERO -->
        <section class="register-hero">
            <h1>Create Account</h1>
            <p>Join Ride On Cars today</p>
        </section>

        <!-- REGISTER FORM -->
        <section class="register-container">

            <!-- TITLE -->
            <h2 class="register-title">Register</h2>

            <!-- FORM -->
            <form method="POST">

                <!-- ERROR -->
                <?php if ($error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <!-- SUCCESS -->
                <?php if ($success): ?>
                    <p class="success"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>

                <!-- NAME -->
                <label for="name">Full Name *</label>
                <input id="name" type="text" name="name"
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

                <!-- EMAIL -->
                <label for="email">Email Address *</label>
                <input id="email" type="email" name="email"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

                <!-- PASSWORD -->
                <label for="password">Password *</label>
                <input id="password" type="password" name="password" required>

                <!-- CONFIRM -->
                <label for="confirm">Confirm Password *</label>
                <input id="confirm" type="password" name="confirm" required>

                <!-- SUBMIT -->
                <button type="submit">Register</button>

                <!-- LOGIN LINK -->
                <p>
                    Already have an account?
                    <a href="login.php">Login here</a>
                </p>

            </form>

        </section>

    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>

</body>

</html>