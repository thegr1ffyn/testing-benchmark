<?php
// Include authentication middleware
require_once 'config/auth_middleware.php';

// Get user information (middleware auto-protects this page)
$user = AuthMiddleware::getUser();
$username = $user['username'];
$login_time = $user['login_time'] ?? time();
$last_activity = $user['last_activity'] ?? time();
$current_time = time();
$session_duration = $current_time - $login_time;
$time_since_activity = $current_time - $last_activity;
$remaining_time = 3600 - $session_duration; // 1 hour - elapsed time

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Information</title>
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
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .info-card h3 {
            margin-top: 0;
            color: #333;
        }
        
        .info-card p {
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
        
        .refresh-btn {
            background: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
    <script>
        // Auto-refresh every 30 seconds
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Session Information</h1>
            <p>Current session details and timeout information</p>
        </div>
        
        <?php if ($remaining_time < 300): // Show warning if less than 5 minutes remaining ?>
        <div class="warning">
            <strong>Warning:</strong> Your session will expire in less than 5 minutes!
        </div>
        <?php endif; ?>
        
        <div class="info-grid">
            <div class="info-card">
                <h3>User Information</h3>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
            </div>
            
            <div class="info-card">
                <h3>Session Timing</h3>
                <p><strong>Login Time:</strong> <?php echo date('Y-m-d H:i:s', $login_time); ?></p>
                <p><strong>Last Activity:</strong> <?php echo date('Y-m-d H:i:s', $last_activity); ?></p>
                <p><strong>Current Time:</strong> <?php echo date('Y-m-d H:i:s', $current_time); ?></p>
            </div>
            
            <div class="info-card">
                <h3>Session Duration</h3>
                <p><strong>Total Duration:</strong> <?php echo gmdate('H:i:s', $session_duration); ?></p>
                <p><strong>Time Since Activity:</strong> <?php echo gmdate('H:i:s', $time_since_activity); ?></p>
            </div>
            
            <div class="info-card">
                <h3>Session Timeout</h3>
                <p><strong>Session Timeout:</strong> 1 hour (3600 seconds)</p>
                <p><strong>Remaining Time:</strong> 
                    <?php 
                    if ($remaining_time > 0) {
                        echo gmdate('H:i:s', $remaining_time);
                    } else {
                        echo "Session should have expired";
                    }
                    ?>
                </p>
            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
            <button onclick="location.reload()" class="refresh-btn">Refresh</button>
        </div>
        
        <div style="margin-top: 20px; padding: 15px; background: #e9ecef; border-radius: 5px;">
            <h4>Session Configuration Details:</h4>
            <ul>
                <li>Session timeout: 1 hour (3600 seconds)</li>
                <li>Session name: AUTH_TEST_SESSION</li>
                <li>Cookie lifetime: 1 hour</li>
                <li>HttpOnly: Enabled (prevents JavaScript access)</li>
                <li>SameSite: Lax (CSRF protection)</li>
                <li>Auto-refresh: Every 30 seconds</li>
            </ul>
        </div>
    </div>
</body>
</html> 