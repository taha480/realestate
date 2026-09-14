<?php
/**
 * AURELIA | Luxury Real Estate & Architectural Construction
 * Admin Authentication — Logout
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/db-functions.php';

startSecureSession();

// Unset all session variables
$_SESSION = [];

// Delete the session cookie if present
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destroy session
session_destroy();

// Redirect back to login page
header('Location: login.php');
exit;
