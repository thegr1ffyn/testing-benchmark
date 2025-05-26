<?php
// Define manual middleware control to prevent auto-redirect
define('AUTH_MIDDLEWARE_MANUAL', true);

// Include authentication middleware
require_once 'config/auth_middleware.php';

// Initialize middleware for protected page
AuthMiddleware::init('protected');

// Get user information
$user = AuthMiddleware::getUser();
$username = $user['username'];

// Get session information
$session_id = session_id();
$session_name = session_name();
$session_start_time = $_SESSION['login_time'] ?? null;
$last_activity = $_SESSION['last_activity'] ?? null;
$current_time = time();

// Calculate session duration and remaining time
$session_duration = $session_start_time ? ($current_time - $session_start_time) : 0;
$time_since_activity = $last_activity ? ($current_time - $last_activity) : 0;
$remaining_time = 3600 - $session_duration; // 1 hour - elapsed time

// Get cookie information
$cookie_params = session_get_cookie_params();
$session_cookie_value = $_COOKIE[$session_name] ?? 'Not found';

// Check if session is about to expire
$is_expiring_soon = $remaining_time < 300; // Less than 5 minutes
$is_expired = $remaining_time <= 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Debug - 1 Hour Persistence Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
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
        
        .info-card.warning {
            border-left-color: #ffc107;
            background: #fff3cd;
        }
        
        .info-card.danger {
            border-left-color: #dc3545;
            background: #f8d7da;
        }
        
        .info-card.success {
            border-left-color: #28a745;
            background: #d4edda;
        }
        
        .info-card h3 {
            margin-top: 0;
            color: #333;
        }
        
        .info-card p {
            margin: 5px 0;
            color: #666;
        }
        
        .info-card .value {
            font-family: monospace;
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
        
        .back-btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .refresh-btn {
            background: #28a745;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .test-section {
            background: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .countdown {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .countdown.warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .countdown.danger {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
    <script>
        // Auto-refresh every 10 seconds
        setTimeout(function() {
            location.reload();
        }, 10000);
        
        // Real-time countdown
        let remainingSeconds = <?php echo max(0, $remaining_time); ?>;
        
        function updateCountdown() {
            const hours = Math.floor(remainingSeconds / 3600);
            const minutes = Math.floor((remainingSeconds % 3600) / 60);
            const seconds = remainingSeconds % 60;
            
            const display = String(hours).padStart(2, '0') + ':' + 
                           String(minutes).padStart(2, '0') + ':' + 
                           String(seconds).padStart(2, '0');
            
            const countdownElement = document.getElementById('countdown');
            if (countdownElement) {
                countdownElement.textContent = display;
                
                // Change color based on remaining time
                if (remainingSeconds < 300) { // Less than 5 minutes
                    countdownElement.className = 'countdown danger';
                } else if (remainingSeconds < 900) { // Less than 15 minutes
                    countdownElement.className = 'countdown warning';
                } else {
                    countdownElement.className = 'countdown';
                }
            }
            
            if (remainingSeconds > 0) {
                remainingSeconds--;
            } else {
                // Session expired
                countdownElement.textContent = 'SESSION EXPIRED';
                countdownElement.className = 'countdown danger';
            }
        }
        
        // Update countdown every second
        setInterval(updateCountdown, 1000);
        updateCountdown(); // Initial call
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🕐 Session Debug - 1 Hour Persistence Test</h1>
            <p>Real-time monitoring of session ID persistence and timeout behavior</p>
        </div>
        
        <div class="countdown" id="countdown">
            <?php echo gmdate('H:i:s', max(0, $remaining_time)); ?>
        </div>
        
        <?php if ($is_expired): ?>
        <div class="info-card danger">
            <h3>⚠️ Session Expired</h3>
            <p>Your session should have expired. If you can still see this page, there might be an issue with session timeout.</p>
        </div>
        <?php elseif ($is_expiring_soon): ?>
        <div class="info-card warning">
            <h3>⏰ Session Expiring Soon</h3>
            <p>Your session will expire in less than 5 minutes. The page will auto-refresh to test timeout behavior.</p>
        </div>
        <?php endif; ?>
        
        <div class="info-grid">
            <div class="info-card">
                <h3>👤 User Information</h3>
                <p><strong>Username:</strong> <span class="value"><?php echo htmlspecialchars($username); ?></span></p>
                <p><strong>User ID:</strong> <span class="value"><?php echo htmlspecialchars($user['id']); ?></span></p>
            </div>
            
            <div class="info-card">
                <h3>🆔 Session ID Information</h3>
                <p><strong>Session ID:</strong> <span class="value"><?php echo htmlspecialchars($session_id); ?></span></p>
                <p><strong>Session Name:</strong> <span class="value"><?php echo htmlspecialchars($session_name); ?></span></p>
                <p><strong>Cookie Value:</strong> <span class="value"><?php echo htmlspecialchars(substr($session_cookie_value, 0, 20)) . '...'; ?></span></p>
            </div>
            
            <div class="info-card">
                <h3>⏱️ Session Timing</h3>
                <p><strong>Login Time:</strong> <span class="value"><?php echo $session_start_time ? date('Y-m-d H:i:s', $session_start_time) : 'Unknown'; ?></span></p>
                <p><strong>Last Activity:</strong> <span class="value"><?php echo $last_activity ? date('Y-m-d H:i:s', $last_activity) : 'Unknown'; ?></span></p>
                <p><strong>Current Time:</strong> <span class="value"><?php echo date('Y-m-d H:i:s', $current_time); ?></span></p>
            </div>
            
            <div class="info-card <?php echo $is_expiring_soon ? 'warning' : ($is_expired ? 'danger' : 'success'); ?>">
                <h3>📊 Session Duration</h3>
                <p><strong>Total Duration:</strong> <span class="value"><?php echo gmdate('H:i:s', $session_duration); ?></span></p>
                <p><strong>Time Since Activity:</strong> <span class="value"><?php echo gmdate('H:i:s', $time_since_activity); ?></span></p>
                <p><strong>Remaining Time:</strong> <span class="value"><?php echo $remaining_time > 0 ? gmdate('H:i:s', $remaining_time) : 'EXPIRED'; ?></span></p>
            </div>
        </div>
        
        <div class="test-section">
            <h3>🔧 Session Configuration Details</h3>
            <div class="info-grid">
                <div>
                    <p><strong>Session Timeout:</strong> 1 hour (3600 seconds)</p>
                    <p><strong>Cookie Lifetime:</strong> <?php echo $cookie_params['lifetime']; ?> seconds</p>
                    <p><strong>Cookie Path:</strong> <?php echo $cookie_params['path']; ?></p>
                    <p><strong>HttpOnly:</strong> <?php echo $cookie_params['httponly'] ? 'Yes' : 'No'; ?></p>
                </div>
                <div>
                    <p><strong>SameSite:</strong> <?php echo $cookie_params['samesite'] ?? 'Not set'; ?></p>
                    <p><strong>Secure:</strong> <?php echo $cookie_params['secure'] ? 'Yes' : 'No'; ?></p>
                    <p><strong>Auto-refresh:</strong> Every 10 seconds</p>
                    <p><strong>Real-time countdown:</strong> Enabled</p>
                </div>
            </div>
        </div>
        
        <div class="test-section">
            <h3>🧪 How to Test 1-Hour Session Persistence</h3>
            <ol>
                <li><strong>Monitor the countdown:</strong> Watch the real-time countdown to see exactly when your session will expire</li>
                <li><strong>Test activity refresh:</strong> Navigate to different pages and come back to see if the session is extended</li>
                <li><strong>Test inactivity:</strong> Leave this page open and don't interact for 1 hour to test timeout</li>
                <li><strong>Check session ID consistency:</strong> The session ID should remain the same throughout the hour</li>
                <li><strong>Test expiration redirect:</strong> When the session expires, you should be redirected to login</li>
            </ol>
        </div>
        
        <div style="text-align: center;">
            <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
            <button onclick="location.reload()" class="refresh-btn">Refresh Now</button>
        </div>
    </div>
</body>
</html> 