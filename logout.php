<?php
// Define manual middleware control
define('AUTH_MIDDLEWARE_MANUAL', true);

// Include authentication middleware
require_once 'config/auth_middleware.php';

// Use middleware to handle logout
AuthMiddleware::logout();

header('Location: index.php');
exit();
?> 