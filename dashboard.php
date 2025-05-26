<?php
// Define manual middleware control
define('AUTH_MIDDLEWARE_MANUAL', true);

// Include authentication middleware
require_once 'config/auth_middleware.php';

// Initialize middleware for protected page
AuthMiddleware::init('protected');

// Get user information
$user = AuthMiddleware::getUser();
$username = $user['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Administration Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            margin: 0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            text-align: center;
        }
        
        .welcome-section h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .welcome-section p {
            color: #666;
            font-size: 18px;
        }
        
        .vulnerability-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
        }
        
        .vulnerability-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .vulnerability-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .vulnerability-card h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 24px;
        }
        
        .vulnerability-card p {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        
        .vulnerability-btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s;
        }
        
        .vulnerability-btn:hover {
            transform: translateY(-2px);
        }
        
        .sql-card {
            border-top: 4px solid #e74c3c;
        }
        
        .xss-card {
            border-top: 4px solid #f39c12;
        }
        
        .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .sql-icon {
            color: #e74c3c;
        }
        
        .xss-icon {
            color: #f39c12;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>IT Administration Portal</h1>
        <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome-section">
            <h2>Welcome to the IT Administration Portal</h2>
            <p>Access our comprehensive suite of database management and user administration tools. Select a category below to begin working with our enterprise systems.</p>
            <?php
            if ($user && $user['login_time']) {
                $session_duration = time() - $user['login_time'];
                $remaining_time = 3600 - $session_duration; // 1 hour - elapsed time
                if ($remaining_time > 0) {
                    $hours = floor($remaining_time / 3600);
                    $minutes = floor(($remaining_time % 3600) / 60);
                    echo '<p style="color: #666; font-size: 14px; margin-top: 15px;">Session expires in: ' . 
                         ($hours > 0 ? $hours . 'h ' : '') . $minutes . 'm</p>';
                }
            }
            ?>
        </div>
        
        <div class="vulnerability-grid">
            <div class="vulnerability-card sql-card">
                <div class="icon sql-icon">🗃️</div>
                <h3>Database Management</h3>
                <p>Access our database administration tools for user management, credential validation, and session monitoring. Essential tools for IT administrators and support staff.</p>
                <a href="sql-challenges.php" class="vulnerability-btn">Access Database Tools</a>
            </div>
            
            <div class="vulnerability-card xss-card">
                <div class="icon xss-icon">⚠️</div>
                <h3>Web Applications</h3>
                <p>Manage web application components, user input processing, and client-side functionality. Tools for web developers and system administrators.</p>
                <a href="xss-challenges.php" class="vulnerability-btn">Access Web Tools</a>
            </div>
        </div>
    </div>
</body>
</html> 