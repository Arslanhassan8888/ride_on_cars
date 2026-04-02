<?php
session_start();

/* HANDLE LOGOUT */
function logout()
{
    // Clear session data
    $_SESSION = [];

    // Destroy session
    session_destroy();

    // Delete session cookie
    if (ini_get("session.use_cookies")) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    // Redirect
    header("Location: index.php");
    exit();
}

/* RUN */
logout();
?>