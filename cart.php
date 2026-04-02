<?php
session_start();
require 'db.php';

/* PROTECT PAGE */
if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* INIT CART */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* INPUT */
$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

/* HANDLE CART */
function handleCart($action, $id)
{
    if ($id <= 0) return;

    // ADD / INCREASE
    if ($action == 'add' || $action == 'increase') {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;

        if ($action == 'add') {
            header("Location: products.php");
            exit();
        }
    }

    // DECREASE
    if ($action == 'decrease') {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]--;

            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }

    // REMOVE
    if ($action == 'remove') {
        unset($_SESSION['cart'][$id]);
    }

    // REFRESH PAGE
    if ($action == 'increase' || $action == 'decrease' || $action == 'remove') {
        header("Location: cart.php");
        exit();
    }
}

/* GET CART ITEMS */
function getCartItems($pdo, $cart)
{
    if (empty($cart)) return [];

    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    return $stmt->fetchAll();
}

/* TOTAL */
function getTotal($items, $cart)
{
    $total = 0;

    foreach ($items as $item) {
        $qty = $cart[$item['id']] ?? 0;
        $total += $item['price'] * $qty;
    }

    return $total;
}

/* RUN */
handleCart($action, $id);

$cartItems = getCartItems($pdo, $_SESSION['cart']);
$total = getTotal($cartItems, $_SESSION['cart']);

$shipping = 10;
$finalTotal = $total + $shipping;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>

    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/cart.css?v=<?php echo filemtime('css/cart.css'); ?>">
</head>

<body>

<?php include 'header.php'; ?>

<main>

<section class="cart-container">
    <h2 class="visually-hidden-heading">Shopping Cart Layout</h2>

    <section class="cart-items">
        <h2 class="visually-hidden-heading">Cart Items</h2>
        <h2>Your Cart</h2>

        <?php if (empty($cartItems)): ?>

            <p>Your cart is empty.</p>
            <a href="products.php">Go to products</a>

        <?php else: ?>

        <?php foreach ($cartItems as $item): ?>

        <?php
        $qty = $_SESSION['cart'][$item['id']];
        $subtotal = $item['price'] * $qty;
        ?>

        <article class="cart-row">

            <figure>
                <img src="images/<?= htmlspecialchars($item['image']) ?>"
                     alt="<?= htmlspecialchars($item['name']) ?>">
            </figure>

            <h2><?= htmlspecialchars($item['name']) ?></h2>

            <p class="price">£<?= number_format($item['price'], 2) ?></p>

            <section class="qty">
                <h3 class="visually-hidden-heading">Quantity controls</h3>

                <a href="cart.php?action=decrease&id=<?= $item['id'] ?>" aria-label="Decrease quantity of <?= htmlspecialchars($item['name']) ?>">−</a>
                <span><?= $qty ?></span>
                <a href="cart.php?action=increase&id=<?= $item['id'] ?>" aria-label="Increase quantity of <?= htmlspecialchars($item['name']) ?>">+</a>
            </section>

            <p class="subtotal">
                £<?= number_format($subtotal, 2) ?>
            </p>

            <a href="cart.php?action=remove&id=<?= $item['id'] ?>" class="btn-delete">
                Delete
            </a>

        </article>

        <?php endforeach; ?>

        <?php endif; ?>

    </section>

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
            <span>£<?= number_format($finalTotal, 2) ?></span>
        </p>

        <button type="button" <?= empty($cartItems) ? 'disabled' : '' ?>>
            Checkout (Coming Soon)
        </button>
    </section>

</section>

</main>

<?php include 'footer.php'; ?>

</body>
</html>