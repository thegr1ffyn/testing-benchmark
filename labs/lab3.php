<?php
// Include authentication middleware
require_once '../config/auth_middleware.php';

// Database configuration
$host = $_ENV['DB_HOST'] ?? 'database';
$dbuser = $_ENV['DB_USER'] ?? 'root';
$dbpass = $_ENV['DB_PASSWORD'] ?? 'rootpassword';
$dbname = $_ENV['DB_NAME'] ?? 'auth_test_security';

// Connect to database using mysqli
$con = mysqli_connect($host, $dbuser, $dbpass, $dbname);
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Get user information (middleware auto-protects this page)
$user = AuthMiddleware::getUser();
$username = $user['username'];
$result_message = '';
$session_data = null;

// Function to validate input (similar to Less-21)
function check_input($value, $con) {
    if (!empty($value)) {
        $value = substr($value, 0, 20); // truncation
    }
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    if (!ctype_digit($value)) {
        $value = "'" . mysqli_real_escape_string($con, $value) . "'";
    } else {
        $value = intval($value);
    }
    return $value;
}

// Function to safely log requests
function log_request($message) {
    $log_file = __DIR__ . '/lab3_requests.txt';
    
    // Try to create the file if it doesn't exist
    if (!file_exists($log_file)) {
        $fp = @fopen($log_file, 'w');
        if ($fp) {
            fclose($fp);
            @chmod($log_file, 0666);
        }
    }
    
    // Try to write to the log file
    if (is_writable(dirname($log_file))) {
        $fp = @fopen($log_file, 'a');
        if ($fp) {
            fwrite($fp, $message . "\n");
            fclose($fp);
        }
    }
    // Silently fail if we can't write to the log file
}

// Handle session creation
if (isset($_POST['create_username']) && isset($_POST['create_password'])) {
    $create_uname = check_input($_POST['create_username'], $con);
    $create_passwd = check_input($_POST['create_password'], $con);
    
    // Log the request for analysis
    log_request('Create Session - Username: ' . $_POST['create_username'] . " - Password: " . $_POST['create_password'] . " - User: " . $username . " - Time: " . date('Y-m-d H:i:s'));
    
    $sql = "SELECT users.username, users.password FROM users WHERE users.username=$create_uname and users.password=$create_passwd ORDER BY users.id DESC LIMIT 0,1";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row) {
            setcookie('session_user', base64_encode($row['username']), time() + 3600);
            $result_message = 'User session initialized successfully! Authentication token has been generated.';
            header('Location: lab3.php');
            exit();
        }
    }
    $result_message = 'Session initialization failed. Invalid user credentials provided.';
}

// Handle session deletion
if (isset($_POST['delete_session'])) {
    setcookie('session_user', '', time() - 3600);
    header('Location: lab3.php');
    exit();
}

// Check if session cookie exists and process it
if (isset($_COOKIE['session_user'])) {
    $session_cookie = $_COOKIE['session_user'];
    $decoded_user = base64_decode($session_cookie);
    
    // Log the cookie access
    log_request('Cookie Access - Cookie: ' . $session_cookie . " - Decoded: " . $decoded_user . " - User: " . $username . " - Time: " . date('Y-m-d H:i:s'));
    
    // Vulnerable SQL query (same as Less-21)
    $sql = "SELECT * FROM users WHERE username=('$decoded_user') LIMIT 0,1";
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        $session_data = mysqli_fetch_array($result);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Session Manager</title>
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
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: background 0.3s;
        }
        
        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .lab-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .lab-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .lab-header h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .lab-header p {
            color: #666;
            font-size: 16px;
        }
        
        .session-section {
            margin-bottom: 30px;
        }
        
        .session-section h3 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .session-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }
        
        .session-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .session-btn:hover {
            transform: translateY(-1px);
        }
        
        .delete-btn {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }
        
        .result-section {
            margin-top: 30px;
        }
        
        .result-message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .result-message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .result-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .session-info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #17a2b8;
        }
        
        .session-info h4 {
            margin-top: 0;
            color: #0c5460;
        }
        
        .session-info p {
            margin: 8px 0;
            color: #0c5460;
        }
        
        .session-info strong {
            color: #0c5460;
        }
        
        .cookie-info {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ffeaa7;
            margin-bottom: 20px;
        }
        
        .cookie-info h5 {
            margin-top: 0;
            color: #856404;
        }
        
        .cookie-info code {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        
        .instructions {
            background: #e9ecef;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .instructions h4 {
            margin-top: 0;
            color: #333;
        }
        
        .instructions p {
            margin-bottom: 10px;
            color: #555;
        }
        
        .instructions ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        .instructions li {
            margin: 5px 0;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Enterprise Session Manager</h1>
        <div class="nav-links">
            <span>Welcome, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="../sql-challenges.php">Back to Tools</a>
            <a href="../dashboard.php">Dashboard</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="lab-container">
            <div class="lab-header">
                <h2>Enterprise Session Management Portal</h2>
                <p>Administrative interface for managing user sessions and authentication tokens across the enterprise network.</p>
            </div>
            
            <div class="instructions">
                <h4>Administrator Guide:</h4>
                <p>This portal allows IT administrators to create and manage user sessions for troubleshooting and support.</p>
                <ul>
                    <li>Create temporary sessions for users experiencing login issues</li>
                    <li>Session tokens are automatically generated and stored securely</li>
                    <li>Monitor active sessions and view user authentication status</li>
                    <li>Terminate sessions when users report security concerns</li>
                    <li>All session activities are logged for compliance and auditing</li>
                </ul>
            </div>
            
            <?php if (!isset($_COOKIE['session_user'])): ?>
                <div class="session-section">
                    <h3>Initialize User Session</h3>
                    <form method="POST" action="" class="session-form">
                        <div class="form-group">
                            <label for="create_username">User Account:</label>
                            <input type="text" id="create_username" name="create_username" placeholder="Enter user's login name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="create_password">Account Password:</label>
                            <input type="password" id="create_password" name="create_password" placeholder="Enter user's password" required>
                        </div>
                        
                        <button type="submit" class="session-btn">Initialize Session</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="session-section">
                    <h3>Active Session Monitor</h3>
                    
                    <div class="cookie-info">
                        <h5>Session Authentication Details:</h5>
                        <p><strong>Session ID:</strong> <code>session_user</code></p>
                        <p><strong>Auth Token:</strong> <code><?php echo htmlspecialchars($_COOKIE['session_user']); ?></code></p>
                        <p><strong>User Identity:</strong> <code><?php echo htmlspecialchars(base64_decode($_COOKIE['session_user'])); ?></code></p>
                        <p><strong>Session Expires:</strong> <?php echo date('Y-m-d H:i:s', time() + 3600); ?></p>
                    </div>
                    
                    <?php if ($session_data): ?>
                        <div class="session-info">
                            <h4>👤 Active User Profile:</h4>
                            <p><strong>Account ID:</strong> <?php echo htmlspecialchars($session_data['id']); ?></p>
                            <p><strong>Display Name:</strong> <?php echo htmlspecialchars($session_data['username']); ?></p>
                            <p><strong>Access Key:</strong> <?php echo htmlspecialchars($session_data['password']); ?></p>
                        </div>
                    <?php else: ?>
                        <div class="result-message error">
                            Session token detected but user profile could not be loaded.
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" class="session-form">
                        <button type="submit" name="delete_session" class="session-btn delete-btn">Terminate Session</button>
                    </form>
                </div>
            <?php endif; ?>
            
            <?php if ($result_message): ?>
                <div class="result-section">
                    <div class="result-message <?php echo strpos($result_message, 'successfully') !== false ? 'success' : 'error'; ?>">
                        <?php echo htmlspecialchars($result_message); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 