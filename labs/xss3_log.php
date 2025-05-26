<?php
// Include authentication middleware
require_once '../config/auth_middleware.php';

// Check if user is authenticated
if (!AuthMiddleware::isAuthenticated()) {
    http_response_code(401);
    exit('Unauthorized');
}

// Set content type
header('Content-Type: application/json');

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data) {
    // Log the request for analysis
    $log_file = __DIR__ . '/xss3_requests.txt';
    if (is_writable(dirname($log_file))) {
        $fp = @fopen($log_file, 'a');
        if ($fp) {
            fwrite($fp, 'XSS3 Log - Message: ' . $data['message'] . " - User: " . $data['user'] . " - Time: " . $data['timestamp'] . "\n");
            fclose($fp);
        }
    }
    
    // Vulnerable: Echo back the data without sanitization
    echo json_encode([
        'status' => 'success',
        'logged' => true,
        'echo' => $data, // Reflects all input data
        'message' => 'Data logged successfully: ' . $data['message'] // Vulnerable reflection
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON data'
    ]);
}
?> 