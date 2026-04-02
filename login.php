<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';

$error = '';

/* GET USER */
function getUser($pdo, $email)
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}

/* VALIDATE */
function validate($email, $password)
{
    if ($email === '' || $password === '') {
        return 'All fields are required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Invalid email format.';
    }

    return '';
}

/* INIT SESSION VALUES */
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

if (!isset($_SESSION['blocked_time'])) {
    $_SESSION['blocked_time'] = 0;
}

/* HANDLE LOGIN */
function handleLogin($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return '';
    }

    if ($_SESSION['blocked_time'] > time()) {
        $left = $_SESSION['blocked_time'] - time();
        return "Account blocked. Try again in $left seconds.";
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $error = validate($email, $password);
    if ($error !== '') {
        return $error;
    }

    $user = getUser($pdo, $email);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);

        $_SESSION['user'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['attempts'] = 0;
        $_SESSION['blocked_time'] = 0;

        header('Location: index.php');
        exit();
    }

    $_SESSION['attempts']++;

    if ($_SESSION['attempts'] >= 3) {
        $_SESSION['blocked_time'] = time() + 300;
        return 'Too many attempts. Blocked for 5 minutes.';
    }

    return 'Invalid login. Attempts left: ' . (3 - $_SESSION['attempts']);
}

/* RUN */
$error = handleLogin($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/login.css?v=<?php echo filemtime('css/login.css'); ?>">
</head>

<body>

    <?php include 'header.php'; ?>

    <main>
        <section class="login-hero">
            <h1>Welcome Back!</h1>
            <p>Login to access your account</p>
        </section>

        <section class="login-container">
            <form method="POST" action="login.php">
                <?php if ($error !== ''): ?>
                    <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>

                <label for="email">Email Address *</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    required>

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