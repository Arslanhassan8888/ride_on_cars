<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* --STATE-- */
$success = "";
$error = "";

/* --HANDLE FORM-- */
/* Process form submission and validate inputs */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* INPUT */
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    /* VALIDATION */
    /* Check for empty fields */
    if ($name && $email && $subject && $message) {

        // future: insert into database
        /* For now, just set success message */
        $success = "Your message has been sent successfully.";
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="UTF-8">
    <title>Contact</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <!-- STYLES -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/contact.css?v=<?php echo filemtime('css/contact.css'); ?>">
</head>

<body>

    <!-- SKIP LINK -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <!-- MAIN -->
    <main id="main-content">

        <!-- HERO -->
        <section class="contact-hero">
            <h1>Contact Us</h1>
            <p>
                Have questions? We’d love to hear from you.
                Send us a message and we’ll respond as soon as possible.
            </p>
        </section>

        <!-- CONTACT LAYOUT -->
        <section class="contact-layout">
            <h2 class="visually-hidden-heading">Contact page content</h2>

            <!-- FORM SECTION -->
            <section class="contact-form">

                <header>
                    <h2>Send us a Message</h2>
                </header>

                <form method="POST">

                    <!-- SUCCESS -->
                    <?php if ($success): ?>
                        <p class="success"><?= $success ?></p>
                    <?php endif; ?>

                    <!-- ERROR -->
                    <?php if ($error): ?>
                        <p class="error"><?= $error ?></p>
                    <?php endif; ?>

                    <!-- NAME -->
                    <label for="name">Full Name *</label>
                    <input id="name" type="text" name="name" required>

                    <!-- EMAIL -->
                    <label for="email">Email *</label>
                    <input id="email" type="email" name="email" required>

                    <!-- SUBJECT -->
                    <label for="subject">Subject *</label>
                    <input id="subject" type="text" name="subject" required>

                    <!-- MESSAGE -->
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" required></textarea>

                    <!-- SUBMIT -->
                    <button type="submit">Send Message</button>

                </form>

            </section>

            <!-- INFO SECTION -->
            <section class="contact-info">

                <header>
                    <h2>Get in Touch</h2>
                    <p>Our team is here to help you anytime.</p>
                </header>

                <section class="info-grid">
                    <h3 class="visually-hidden-heading">Contact information cards</h3>

                    <!-- EMAIL -->
                    <article class="card">
                        <h3>Email</h3>
                        <p>support@rideonkids.com</p>
                        <p>sales@rideonkids.com</p>
                    </article>

                    <!-- PHONE -->
                    <article class="card">
                        <h3>Phone</h3>
                        <p>+44 161 123 4567</p>
                        <p>+44 074 5466 8005</p>
                    </article>

                    <!-- ADDRESS -->
                    <article class="card">
                        <h3>Address</h3>
                        <p>45 Market Street</p>
                        <p>Manchester, M1 1AA</p>
                    </article>

                    <!-- HOURS -->
                    <article class="card">
                        <h3>Hours</h3>
                        <p>Mon - Fri: 9am - 6pm</p>
                        <p>Sat: 10am - 4pm</p>
                    </article>

                </section>

            </section>

        </section>

    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>

</body>

</html>