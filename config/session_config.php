<?php
// Session Configuration
// Set session timeout to 1 hour (3600 seconds)

// Configure session settings before starting session
ini_set('session.gc_maxlifetime', 3600);     // 1 hour - server-side session lifetime
ini_set('session.gc_probability', 1);        // Garbage collection probability
ini_set('session.gc_divisor', 1000);         // Reduced frequency to prevent premature cleanup
ini_set('session.cookie_lifetime', 3600);    // 1 hour - cookie lifetime
ini_set('session.cache_expire', 60);         // Cache expire in minutes (1 hour)

// Configure session cookie parameters before starting session
session_set_cookie_params([
    'lifetime' => 3600,        // 1 hour in seconds
    'path' => '/',             // Available for entire domain
    'domain' => '',            // Current domain
    'secure' => false,         // Set to true if using HTTPS
    'httponly' => true,        // Prevent JavaScript access
    'samesite' => 'Lax'        // CSRF protection
]);

// Set session name
session_name('AUTH_TEST_SESSION');

// Start the session
session_start();

// Extend session cookie lifetime on each request to maintain 1-hour sliding window
if (isset($_SESSION['user_id'])) {
    // Update last activity timestamp
    $_SESSION['last_activity'] = time();
    
    // Refresh the session cookie to extend its lifetime
    $cookie_params = session_get_cookie_params();
    setcookie(
        session_name(),
        session_id(),
        time() + 3600,  // Extend for another hour from now
        $cookie_params['path'],
        $cookie_params['domain'],
        $cookie_params['secure'],
        $cookie_params['httponly']
    );
}
?> 