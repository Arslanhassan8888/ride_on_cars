<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

/* --STATE-- */
$error = '';

/* --GET USER-- */
function getUser($pdo, $email)
{/* Fetch user by email for authentication */
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}

/* --VALIDATE-- */
function validate($email, $password)
{/* Basic validation for login inputs */
    if ($email === '' || $password === '') {
        return 'All fields are required.';
    }
    /* Validate email format */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email format.';
    }

    return '';
}

/* --SECURITY-- */
/* Initialize login attempt tracking for brute-force protection */
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}
/* Initialize block time for brute-force protection */
if (!isset($_SESSION['blocked_time'])) {
    $_SESSION['blocked_time'] = 0;
}

/* --HANDLE LOGIN-- */
function handleLogin($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return '';
    }

    /* BLOCK CHECK */
    if ($_SESSION['blocked_time'] > time()) {
        $left = $_SESSION['blocked_time'] - time();
        return "Account blocked. Try again in $left seconds.";
    }

    /* INPUT */
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    /* VALIDATION */
    $error = validate($email, $password);
    if ($error !== '') {
        return $error;
    }

    /* AUTH */
    /* Get user by email */
    $user = getUser($pdo, $email);
    /* Verify password and set session if successful */
    if ($user && password_verify($password, $user['password'])) {
        /* Regenerate session ID to prevent fixation attacks */
        session_regenerate_id(true);
        /* Set session variables for user state */
        $_SESSION['user'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];
        /*  Reset login attempts and block time on successful login */
        $_SESSION['attempts'] = 0;
        $_SESSION['blocked_time'] = 0;
        /* Redirect to homepage after successful login */
        header('Location: index.php');
        exit();
    }

    /* FAILED */
    /* Increment login attempts and set block time if necessary */
    $_SESSION['attempts']++;
    /* If attempts exceed threshold, block for 5 minutes */
    if ($_SESSION['attempts'] >= 3) {
        $_SESSION['blocked_time'] = time() + 300;
        return 'Too many attempts. Blocked for 5 minutes.';
    }
    /* Return error message with remaining attempts */
    return 'Invalid login. Attempts left: ' . (3 - $_SESSION['attempts']);
}

/* --RUN-- */
/* Handle login and capture any error messages */
$error = handleLogin($pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <!-- STYLES -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/login.css?v=<?php echo filemtime('css/login.css'); ?>">
</head>

<body>

    <!-- SKIP LINK -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <!-- MAIN CONTENT -->
    <main id="main-content">

        <!-- HERO -->
        <section class="login-hero">
            <h1>Welcome Back!</h1>
            <p>Login to access your account</p>
        </section>

        <!-- LOGIN SECTION -->
        <section class="login-container">

            <!-- TITLE -->
            <h2 class="login-title">Login</h2>

            <!-- FORM -->
            <form method="POST" action="login.php">

                <!-- ERROR -->
                <?php if ($error !== ''): ?>
                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <!-- EMAIL -->
                <label for="email">Email Address *</label>
                <input id="email" type="email" name="email"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>

                <!-- PASSWORD -->
                <label for="password">Password *</label>
                <input id="password" type="password" name="password" required>

                <!-- SUBMIT -->
                <button type="submit">Login</button>

                <!-- REGISTER LINK -->
                <p>
                    Don’t have an account?
                    <a href="register.php">Register here</a>
                </p>

            </form>

        </section>

    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>

</body>
</html>