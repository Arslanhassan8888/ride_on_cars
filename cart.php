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

// ADD TO CART
if ($action === 'add' && $id > 0) {

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++; // increase quantity
    } else {
        $_SESSION['cart'][$id] = 1; // add new item
    }

    // Redirect back to products
    header("Location: products.php");
    exit();
}