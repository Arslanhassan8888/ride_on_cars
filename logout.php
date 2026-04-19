<?php
session_start();

/* --HANDLE LOGOUT-- */
/* Clears session, destroys it, and redirects user */
function logout()
{
    /* --CLEAR SESSION DATA-- */
    $_SESSION = [];

    /* --DESTROY SESSION-- */
    session_destroy();

    /* --DELETE SESSION COOKIE-- */
    if (ini_get("session.use_cookies")) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    /* --REDIRECT-- */
    header("Location: index.php");
    exit();
}

/* --RUN-- */
logout();
