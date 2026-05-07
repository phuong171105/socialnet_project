<?php
// ============================================================
// Sign Out Page
// URL: /socialnet/signout.php
// ============================================================
require_once __DIR__ . '/../config/session.php';

// Destroy session fully
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}
session_destroy();

// Redirect to Sign In page
header('Location: /socialnet/signin.php');
exit;
