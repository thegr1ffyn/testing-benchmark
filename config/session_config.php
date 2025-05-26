<?php
// Session Configuration
// Set session timeout to 1 hour (3600 seconds)

// Configure session cookie parameters before starting session
session_set_cookie_params([
    'lifetime' => 3600,        // 1 hour in seconds
    'path' => '/',             // Available for entire domain
    'domain' => '',            // Current domain
    'secure' => false,         // Set to true if using HTTPS
    'httponly' => true,        // Prevent JavaScript access
    'samesite' => 'Lax'        // CSRF protection
]);

// Set session garbage collection
ini_set('session.gc_maxlifetime', 3600);  // 1 hour
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);

// Set session name
session_name('AUTH_TEST_SESSION');

// Start the session
session_start();

// Update last activity timestamp if user is logged in
if (isset($_SESSION['user_id'])) {
    $_SESSION['last_activity'] = time();
}
?> 