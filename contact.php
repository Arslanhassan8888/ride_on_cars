<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if ($name && $email && $subject && $message) {

        // here you could insert into database later

        $success = "Your message has been sent successfully.";
    } else {
        $error = "Please fill all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/contact.css?v=<?php echo filemtime('css/contact.css'); ?>">
</head>

<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include 'header.php'; ?>

    <main id="main-content">

        <!-- HERO (SAME AS ABOUT) -->
        <section class="contact-hero">
            <h1>Contact Us</h1>
            <p>
                Have questions? We’d love to hear from you.
                Send us a message and we’ll respond as soon as possible.
            </p>
        </section>

        <!-- CONTACT SECTION -->
        <section class="contact-layout">
            <h2 class="visually-hidden-heading">Contact page content</h2>

            <!-- FORM -->
            <section class="contact-form">

                <header>
                    <h2>Send us a Message</h2>
                </header>

                <form method="POST">
                    <?php if ($success): ?>
                        <p class="success"><?= $success ?></p>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <p class="error"><?= $error ?></p>
                    <?php endif; ?>

                    <label for="name">Full Name *</label>
                    <input id="name" type="text" name="name" placeholder="John Doe" required>

                    <label for="email">Email *</label>
                    <input id="email" type="email" name="email" placeholder="example@mail.com" required>

                    <label for="subject">Subject *</label>
                    <input id="subject" type="text" name="subject" placeholder="Order inquiry" required>

                    <label for="message">Message *</label>
                    <textarea id="message" name="message" placeholder="Write your message..." required></textarea>

                    <button type="submit">Send Message</button>

                </form>

            </section>

            <!-- INFO CARDS -->
            <section class="contact-info">

                <header>
                    <h2>Get in Touch</h2>
                    <p>Our team is here to help you anytime.</p>
                </header>

                <section class="info-grid">
                    <h3 class="visually-hidden-heading">Contact information cards</h3>

                    <article class="card">
                        <h3>Email</h3>
                        <p>support@rideonkids.com</p>
                        <p>sales@rideonkids.com</p>
                    </article>

                    <article class="card">
                        <h3>Phone</h3>
                        <p>+44 161 123 4567</p>
                        <p>+44 074 5466 8005</p>
                    </article>

                    <article class="card">
                        <h3>Address</h3>
                        <p>45 Market Street</p>
                        <p>Manchester, M1 1AA</p>
                    </article>

                    <article class="card">
                        <h3>Hours</h3>
                        <p>Mon - Fri: 9am - 6pm</p>
                        <p>Sat: 10am - 4pm</p>
                    </article>

                </section>

            </section>

        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>