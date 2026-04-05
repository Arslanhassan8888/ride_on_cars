<?php

/* Ensure base path exists (fallback if header not loaded) */
if (!isset($base)) {
    $base = '';
}
?>

<footer class="site-footer">

    <!-- FOOTER INFORMATION -->
    <section class="footer-info">
        <h2 class="visually-hidden">Additional information</h2>
        <p class="footer-title">Ride On Cars</p>
        <p>Safe and fun cars for kids.</p>
    </section>

    <!-- FOOTER NAVIGATION -->
    <nav class="footer-nav" aria-label="Footer navigation">
        <ul>
            <li><a href="<?php echo $base; ?>index.php">Home</a></li>
            <li><a href="<?php echo $base; ?>about.php">About</a></li>
            <li><a href="<?php echo $base; ?>products.php">Products</a></li>
            <li><a href="<?php echo $base; ?>contact.php">Contact</a></li>
            <li><a href="<?php echo $base; ?>reviews.php">Reviews</a></li>
        </ul>
    </nav>

    <!-- COPYRIGHT -->
    <p class="footer-copy">
        &copy; <?php echo date("Y"); ?> Ride On Cars
    </p>

</footer>

<!-- MAIN JAVASCRIPT -->
<script src="<?php echo $base; ?>js/main.js"></script>