<?php
// Include authentication middleware
require_once 'config/auth_middleware.php';

// Get user information (middleware auto-protects this page)
$user = AuthMiddleware::getUser();
$username = $user['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Middleware Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .test-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }
        
        .test-section h3 {
            margin-top: 0;
            color: #333;
        }
        
        .test-section p {
            margin: 5px 0;
            color: #666;
        }
        
        .back-btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        
        .test-links {
            background: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .test-links h4 {
            margin-top: 0;
            color: #333;
        }
        
        .test-links a {
            display: inline-block;
            margin: 5px 10px 5px 0;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .test-links a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛡️ Authentication Middleware Test</h1>
            <p>Testing the authentication middleware functionality</p>
        </div>
        
        <div class="test-section">
            <h3>✅ Middleware Status: WORKING</h3>
            <p><strong>Current User:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
            <p><strong>Authentication Status:</strong> <?php echo AuthMiddleware::isAuthenticated() ? 'Authenticated' : 'Not Authenticated'; ?></p>
            <p><strong>Current Page:</strong> <?php echo AuthMiddleware::getCurrentPage(); ?></p>
        </div>
        
        <div class="test-section">
            <h3>🔒 Middleware Features</h3>
            <ul>
                <li><strong>Auto-redirect:</strong> Automatically redirects based on authentication status</li>
                <li><strong>Session timeout:</strong> Handles 1-hour session expiration</li>
                <li><strong>Path detection:</strong> Works correctly in subdirectories (/labs/)</li>
                <li><strong>Protected pages:</strong> Automatically protects dashboard, labs, and tools</li>
                <li><strong>Guest pages:</strong> Redirects authenticated users away from login</li>
                <li><strong>Centralized auth:</strong> Single point of authentication control</li>
            </ul>
        </div>
        
        <div class="test-links">
            <h4>Test Navigation (All Protected by Middleware):</h4>
            <a href="dashboard.php">Dashboard</a>
            <a href="sql-challenges.php">SQL Tools</a>
            <a href="xss-challenges.php">XSS Tools</a>
            <a href="session_test.php">Session Info</a>
            <a href="labs/lab1.php">Lab 1</a>
            <a href="labs/xss1.php">XSS Lab 1</a>
            <a href="logout.php">Logout</a>
        </div>
        
        <div class="test-section">
            <h3>🧪 How to Test the Middleware</h3>
            <ol>
                <li><strong>Logout Test:</strong> Click logout and try to access any protected page</li>
                <li><strong>Direct Access:</strong> Try accessing <code>/dashboard.php</code> without login</li>
                <li><strong>Login Redirect:</strong> Try accessing <code>/index.php</code> while logged in</li>
                <li><strong>Session Timeout:</strong> Wait 1 hour or modify session timeout for testing</li>
                <li><strong>Lab Access:</strong> Try accessing lab pages directly without authentication</li>
            </ol>
        </div>
        
        <div style="text-align: center;">
            <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html> 