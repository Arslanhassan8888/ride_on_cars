<?php
session_start();
require 'db.php';

// Protect cart
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get action
$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

// HANDLE CART ACTIONS
function handleCartAction($action, $id)
{

    if ($id <= 0) return;

    // Increase
    if ($action === 'increase' && isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    }

    // Decrease
    if ($action === 'decrease' && isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]--;

        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }

    // Remove
    if ($action === 'remove' && isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    // Redirect after action
    if ($action === 'increase' || $action === 'decrease' || $action === 'remove') {
        header("Location: cart.php");
        exit();
    }
}

// FETCH PRODUCTS
function getCartItems($pdo, $cart)
{

    if (empty($cart)) return [];

    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    return $stmt->fetchAll();
}

// CALCULATE TOTAL
function calculateTotal($cartItems, $cart)
{

    $total = 0;

    foreach ($cartItems as $product) {

        $qty = $cart[$product['id']] ?? 0;

        if (is_numeric($qty)) {
            $total += $product['price'] * $qty;
        }
    }

    return $total;
}

// RUN ACTION
handleCartAction($action, $id);

// GET ITEMS
$cartItems = getCartItems($pdo, $_SESSION['cart']);

// CALCULATE
$total = calculateTotal($cartItems, $_SESSION['cart']);
$shipping = 10;
$totalWithShipping = $total + $shipping;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cart</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <main>

        <!-- CART CONTAINER -->
        <section class="cart-container">

            <!-- LEFT: ITEMS -->
            <section class="cart-items">

                <h1>Your Cart</h1>

                <!-- ITEM 1 -->
                <article class="cart-row">

                    <figure>
                        <img src="images/car1.png" alt="Car">
                    </figure>

                    <h2>BMW X5 Ride-On</h2>

                    <p class="price">£120.00</p>

                    <!-- QUANTITY -->
                    <section class="qty">
                        <a href="#">−</a>
                        <span>1</span>
                        <a href="#">+</a>
                    </section>

                    <!-- SUBTOTAL -->
                    <p class="subtotal">£120.00</p>

                    <!-- REMOVE -->
                    <a href="#" class="remove">🗑</a>

                </article>

                <!-- ITEM 2 -->
                <article class="cart-row">

                    <figure>
                        <img src="images/car2.png" alt="Car">
                    </figure>

                    <h2>Audi RS Ride-On</h2>

                    <p class="price">£150.00</p>

                    <section class="qty">
                        <a href="#">−</a>
                        <span>2</span>
                        <a href="#">+</a>
                    </section>

                    <p class="subtotal">£300.00</p>

                    <a href="#" class="remove">🗑</a>

                </article>

            </section>

            <!-- RIGHT: SUMMARY -->
            <section class="summary">

                <h2>Order Summary</h2>

                <p>
                    Subtotal
                    <span>£420.00</span>
                </p>

                <p>
                    Shipping
                    <span>£10.00</span>
                </p>

                <hr>

                <p class="total">
                    Total
                    <span>£430.00</span>
                </p>

                <button>Proceed to Checkout</button>

            </section>

        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>