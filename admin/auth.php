<?php

/* --START SESSION-- */
/* Start session if not already active */
/* This is necessary for authentication and session management */
function startSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}


/* --SECURE SESSION-- */
/* Prevent session fixation by regenerating ID once */
function secureSession()
{      /* Regenerate session ID on first check to prevent fixation */
    if (!isset($_SESSION['admin_checked'])) {
        session_regenerate_id(true);
        $_SESSION['admin_checked'] = true;
    }
}


/* --CHECK ADMIN-- */
/* Verify user is logged in and has admin role */
function isAdmin()
{
    return isset($_SESSION['user_id']) &&
        isset($_SESSION['role']) &&
        $_SESSION['role'] === 'admin';
}


/* --PROTECT PAGE-- */
/* Redirect non-admin users */
function protectAdmin()
{
    if (!isAdmin()) {
        header("Location: ../index.php");
        exit();
    }
}


/* --RUN-- */
/* Execute authentication checks */
startSession();
secureSession();
protectAdmin();
