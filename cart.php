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
function handleCartAction($action, $id) {

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
function getCartItems($pdo, $cart) {

    if (empty($cart)) return [];

    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    return $stmt->fetchAll();
}

// CALCULATE TOTAL
function calculateTotal($cartItems, $cart) {

    $total = 0;

    foreach ($cartItems as $product) {
        $total += $product['price'] * $cart[$product['id']];
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