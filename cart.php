<?php
session_start();
require 'db.php';

/* PROTECT PAGE */
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

/* INIT CART */
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* INPUT */
$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/* HANDLE CART */
function handleCartAction($action, $id)
{
    if ($id <= 0) return;

    if (!isset($_SESSION['cart'][$id]) || !is_numeric($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 0;
    }

    if ($action === 'add') {
        $_SESSION['cart'][$id]++;
        header("Location: products.php");
        exit();
    }

    if ($action === 'increase') {
        $_SESSION['cart'][$id]++;
    }

    if ($action === 'decrease') {
        $_SESSION['cart'][$id]--;

        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }

    if ($action === 'remove') {
        unset($_SESSION['cart'][$id]);
    }

    if (in_array($action, ['increase', 'decrease', 'remove'])) {
        header("Location: cart.php");
        exit();
    }
}

/* FETCH PRODUCTS */
function getCartItems($pdo, $cart)
{
    if (empty($cart)) return [];

    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* TOTAL */
function calculateTotal($cartItems, $cart)
{
    $total = 0;

    foreach ($cartItems as $product) {
        $qty = $cart[$product['id']] ?? 0;

        if (!is_numeric($qty)) $qty = 0;

        $total += (float)$product['price'] * (int)$qty;
    }

    return $total;
}

/* RUN */
handleCartAction($action, $id);

$cartItems = getCartItems($pdo, $_SESSION['cart']);
$total = calculateTotal($cartItems, $_SESSION['cart']);

$shipping = 10;
$totalWithShipping = $total + $shipping;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
</head>

<body>

<?php include 'header.php'; ?>

<main>

<section class="cart-container">

    <!-- ITEMS -->
    <section class="cart-items">

        <h1>Your Cart</h1>

        <?php if (empty($cartItems)): ?>

            <p>Your cart is empty.</p>
            <a href="products.php">Go to products</a>

        <?php else: ?>

        <?php foreach ($cartItems as $product): ?>

        <?php
        $qty = $_SESSION['cart'][$product['id']];
        $subtotal = $product['price'] * $qty;
        ?>

        <article class="cart-row">

            <figure>
                <img src="images/<?= htmlspecialchars($product['image']) ?>"
                     alt="<?= htmlspecialchars($product['name']) ?>">
            </figure>

            <h2><?= htmlspecialchars($product['name']) ?></h2>

            <p class="price">£<?= number_format($product['price'], 2) ?></p>

            <!-- QTY -->
            <section class="qty">

                <a href="cart.php?action=decrease&id=<?= $product['id'] ?>"
                   class="btn-decrease"
                   data-qty="<?= $qty ?>">−</a>

                <span><?= $qty ?></span>

                <a href="cart.php?action=increase&id=<?= $product['id'] ?>">+</a>

            </section>

            <!-- SUBTOTAL -->
            <p class="subtotal">
                £<?= number_format($subtotal, 2) ?>
            </p>

            <!-- DELETE -->
            <a href="cart.php?action=remove&id=<?= $product['id'] ?>"
               class="btn-delete">
               Delete
            </a>

        </article>

        <?php endforeach; ?>

        <?php endif; ?>

    </section>

    <!-- SUMMARY -->
    <section class="summary">

        <h2>Order Summary</h2>

        <p>
            Subtotal
            <span>£<?= number_format($total, 2) ?></span>
        </p>

        <p>
            Shipping
            <span>£<?= number_format($shipping, 2) ?></span>
        </p>

        <hr>

        <p class="total">
            Total
            <span>£<?= number_format($totalWithShipping, 2) ?></span>
        </p>

        <button <?= empty($cartItems) ? 'disabled' : '' ?>>
            Proceed to Checkout
        </button>

    </section>

</section>

</main>

<?php include 'footer.php'; ?>

<!-- JS FILE -->
<script src="js/cart.js"></script>

</body>
</html>