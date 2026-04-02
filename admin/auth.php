<?php

/* START SESSION */
function startSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/* SECURE SESSION */
function secureSession()
{
    if (!isset($_SESSION['admin_checked'])) {
        session_regenerate_id(true);
        $_SESSION['admin_checked'] = true;
    }
}

/* CHECK ADMIN ROLE */
function isAdmin()
{
    return isset($_SESSION['user_id']) &&
           isset($_SESSION['role']) &&
           $_SESSION['role'] === 'admin';
}

/* REDIRECT IF NOT ADMIN */
function protectAdmin()
{
    if (!isAdmin()) {
        header("Location: ../index.php");
        exit();
    }
}

/* RUN ALL */
startSession();
secureSession();
protectAdmin();

?>
