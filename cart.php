<?php
session_start();
require 'db.php';

/* --PROTECT PAGE-- */
if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* --INIT CART-- */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* --INPUT-- */
$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);


/* --HANDLE CART-- */
/* Add, remove, increase, decrease items */
function handleCart($action, $id)
{   /* --VALIDATE ID-- */
    if ($id <= 0) return;

    /* --ADD / INCREASE-- */
    if ($action == 'add' || $action == 'increase') {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        /* After adding, redirect to products page to prevent multiple additions on refresh */
        if ($action == 'add') {
            header("Location: products.php");
            exit();
        }
    }

    /* --DECREASE-- */
    /* Decrease quantity or remove if it reaches zero */
    if ($action == 'decrease') {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]--;
            /* Remove from cart if quantity is zero or less */
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }

    /* --REMOVE-- */
    if ($action == 'remove') {
        unset($_SESSION['cart'][$id]);
    }

    /* --REFRESH-- */
    /* Redirect back to cart page after any action to prevent form resubmission issues */
    if ($action == 'increase' || $action == 'decrease' || $action == 'remove') {
        header("Location: cart.php");
        exit();
    }
}


/* --GET CART ITEMS-- */
/* Fetch product details for items in the cart based on their IDs */
function getCartItems($pdo, $cart)
{   /* If cart is empty, return an empty array to avoid unnecessary database query */
    if (empty($cart)) return [];
    /* Prepare a query with placeholders for each product ID in the cart */
    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    /* Execute the query and fetch the product details */
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    /*  Return the fetched products as an array */
    return $stmt->fetchAll();
}


/* --TOTAL CALCULATION-- */
/* Calculate the total cost of items in the cart by multiplying price and quantity */
function getTotal($items, $cart)
{
    $total = 0;

    foreach ($items as $item) {
        $qty = $cart[$item['id']] ?? 0;
        $total += $item['price'] * $qty;
    }

    return $total;
}


/* --RUN-- */
/*  Handle cart actions based on URL parameters, then fetch cart items and calculate totals for display */
handleCart($action, $id);
/* Fetch product details for items currently in the cart */
$cartItems = getCartItems($pdo, $_SESSION['cart']);
$total = getTotal($cartItems, $_SESSION['cart']);

$shipping = 10;
$finalTotal = $total + $shipping;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="UTF-8">
    <title>Your Cart</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="images/car_logo.png">

    <!-- STYLES -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link rel="stylesheet" href="css/cart.css?v=<?php echo filemtime('css/cart.css'); ?>">
</head>

<body>

    <!-- SKIP LINK -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- HEADER -->
    <?php include 'header.php'; ?>

    <!-- MAIN -->
    <main id="main-content">

        <!-- CART CONTAINER -->
        <section class="cart-container">
            <h2 class="visually-hidden-heading">Shopping Cart Layout</h2>

            <!-- CART ITEMS -->
            <section class="cart-items">

                <h2 class="visually-hidden-heading">Cart Items</h2>
                <h2>Your Cart</h2>

                <!-- EMPTY CART -->
                <?php if (empty($cartItems)): ?>

                    <p>Your cart is empty.</p>
                    <a href="products.php">Go to products</a>

                <?php else: ?>

                    <!-- PRODUCT LOOP -->
                    <?php foreach ($cartItems as $item): ?>

                        <?php
                        $qty = $_SESSION['cart'][$item['id']];
                        $subtotal = $item['price'] * $qty;
                        ?>

                        <article class="cart-row">

                            <!-- IMAGE -->
                            <figure>
                                <img src="images/<?= htmlspecialchars($item['image']) ?>"
                                    alt="<?= htmlspecialchars($item['name']) ?>">
                            </figure>

                            <!-- NAME -->
                            <h2><?= htmlspecialchars($item['name']) ?></h2>

                            <!-- PRICE -->
                            <p class="price">£<?= number_format($item['price'], 2) ?></p>

                            <!-- QUANTITY -->
                            <section class="qty">
                                <h3 class="visually-hidden-heading">Quantity controls</h3>

                                <a href="cart.php?action=decrease&id=<?= $item['id'] ?>">−</a>
                                <span><?= $qty ?></span>
                                <a href="cart.php?action=increase&id=<?= $item['id'] ?>">+</a>
                            </section>

                            <!-- SUBTOTAL -->
                            <p class="subtotal">£<?= number_format($subtotal, 2) ?></p>

                            <!-- DELETE -->
                            <a href="cart.php?action=remove&id=<?= $item['id'] ?>" class="btn-delete">
                                Delete
                            </a>

                        </article>

                    <?php endforeach; ?>
                <?php endif; ?>

            </section>

            <!-- SUMMARY -->
            <section class="summary">

                <h2>Order Summary</h2>

                <!-- SUBTOTAL -->
                <p>
                    Subtotal
                    <span>£<?= number_format($total, 2) ?></span>
                </p>

                <!-- SHIPPING -->
                <p>
                    Shipping
                    <span>£<?= number_format($shipping, 2) ?></span>
                </p>

                <hr>

                <!-- TOTAL -->
                <p class="total">
                    Total
                    <span>£<?= number_format($finalTotal, 2) ?></span>
                </p>

                <!-- CHECKOUT -->
                <button type="button" <?= empty($cartItems) ? 'disabled' : '' ?>>
                    Checkout (Coming Soon)
                </button>

            </section>

        </section>

    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>

</body>

</html>