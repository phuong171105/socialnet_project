<?php
// ----------------------------------------------------------------
// Session bootstrap – include at the top of every protected page.
// ----------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Returns true when a user is currently authenticated.
 */
function is_logged_in(): bool
{
    return isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0;
}

/**
 * Redirect to Signin Page if the visitor is not logged in.
 */
function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: /socialnet/signin.php');
        exit;
    }
}
