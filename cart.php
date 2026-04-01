<?php
session_start();
require 'db.php';

// Protect cart (must be logged in)
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

// INCREASE
if ($action === 'increase' && $id > 0) {
    $_SESSION['cart'][$id]++;
    header("Location: cart.php");
    exit();
}

// DECREASE
if ($action === 'decrease' && $id > 0) {
    $_SESSION['cart'][$id]--;

    if ($_SESSION['cart'][$id] <= 0) {
        unset($_SESSION['cart'][$id]);
    }

    header("Location: cart.php");
    exit();
}

// REMOVE
if ($action === 'remove' && $id > 0) {
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}