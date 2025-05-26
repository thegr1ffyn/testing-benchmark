<?php
// Define manual middleware control to prevent auto-redirect
define('AUTH_MIDDLEWARE_MANUAL', true);

// Include authentication middleware
require_once 'config/auth_middleware.php';

// Get debug information
$current_page = AuthMiddleware::getCurrentPage();
$is_authenticated = AuthMiddleware::isAuthenticated();
$user = AuthMiddleware::getUser();

echo "<h1>Middleware Debug Information</h1>";
echo "<p><strong>Current Page:</strong> " . htmlspecialchars($current_page) . "</p>";
echo "<p><strong>Is Authenticated:</strong> " . ($is_authenticated ? 'YES' : 'NO') . "</p>";
echo "<p><strong>Current URL:</strong> " . htmlspecialchars($_SERVER['REQUEST_URI']) . "</p>";
echo "<p><strong>PHP Self:</strong> " . htmlspecialchars($_SERVER['PHP_SELF']) . "</p>";

if ($user) {
    echo "<p><strong>User ID:</strong> " . htmlspecialchars($user['id']) . "</p>";
    echo "<p><strong>Username:</strong> " . htmlspecialchars($user['username']) . "</p>";
} else {
    echo "<p><strong>User:</strong> Not logged in</p>";
}

// Test protected pages array
$protected_pages = [
    'dashboard',
    'sql-challenges', 
    'xss-challenges',
    'session_test',
    'middleware_test',
    'lab1', 'lab2', 'lab3',
    'xss1', 'xss2', 'xss3', 'xss3_log'
];

echo "<h2>Protected Pages Check</h2>";
echo "<p><strong>Is current page in protected list:</strong> " . (in_array($current_page, $protected_pages) ? 'YES' : 'NO') . "</p>";

// Test what would happen with auto-redirect
echo "<h2>Auto-Redirect Logic Test</h2>";
if (in_array($current_page, $protected_pages)) {
    if (!$is_authenticated) {
        echo "<p style='color: red;'><strong>Would redirect to:</strong> index.php (not authenticated)</p>";
    } else {
        echo "<p style='color: green;'><strong>Would allow access</strong> (authenticated user accessing protected page)</p>";
    }
} else {
    echo "<p style='color: blue;'><strong>Page not protected</strong> - no redirect needed</p>";
}

// Test guest-only pages
$guest_only_pages = ['index'];
if (in_array($current_page, $guest_only_pages)) {
    if ($is_authenticated) {
        echo "<p style='color: orange;'><strong>Would redirect to:</strong> dashboard.php (authenticated user on guest page)</p>";
    } else {
        echo "<p style='color: green;'><strong>Would allow access</strong> (guest on guest page)</p>";
    }
}

echo "<h2>Test Links</h2>";
echo "<p><a href='dashboard.php'>Dashboard</a></p>";
echo "<p><a href='sql-challenges.php'>SQL Challenges</a></p>";
echo "<p><a href='labs/lab1.php'>Lab 1</a></p>";
echo "<p><a href='labs/lab2.php'>Lab 2</a></p>";
echo "<p><a href='labs/xss1.php'>XSS Lab 1</a></p>";
echo "<p><a href='index.php'>Index (Login)</a></p>";
echo "<p><a href='logout.php'>Logout</a></p>";

echo "<h2>Expected Behavior</h2>";
if ($is_authenticated) {
    echo "<p style='color: green;'><strong>You are authenticated:</strong></p>";
    echo "<ul>";
    echo "<li>Dashboard, SQL Challenges, Labs → Should work normally</li>";
    echo "<li>Index (Login) → Should redirect to Dashboard</li>";
    echo "<li>Logout → Should log you out and redirect to Index</li>";
    echo "</ul>";
} else {
    echo "<p style='color: red;'><strong>You are NOT authenticated:</strong></p>";
    echo "<ul>";
    echo "<li>Dashboard, SQL Challenges, Labs → Should redirect to Index (Login)</li>";
    echo "<li>Index (Login) → Should work normally</li>";
    echo "</ul>";
}
?> 