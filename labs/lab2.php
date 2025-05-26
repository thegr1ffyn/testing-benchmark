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
$login_success = false;

// Handle authentication test
if (isset($_POST['test_username']) && isset($_POST['test_password'])) {
    $test_uname = $_POST['test_username'];
    $test_passwd = $_POST['test_password'];
    
    // Log the request for analysis
    $fp = fopen('lab2_requests.txt', 'a');
    fwrite($fp, 'Username: ' . $test_uname . " - Password: " . $test_passwd . " - User: " . $username . " - Time: " . date('Y-m-d H:i:s') . "\n");
    fclose($fp);
    
    // Vulnerable SQL query (same as Less-16)
    $test_uname = '"' . $test_uname . '"';
    $test_passwd = '"' . $test_passwd . '"';
    $sql = "SELECT username, password FROM users WHERE username=($test_uname) and password=($test_passwd) LIMIT 0,1";
            $result = mysqli_query($con, $sql);
        
        if ($result) {
            $row = mysqli_fetch_array($result);
        if ($row) {
            $login_success = true;
            $result_message = 'Credentials verified successfully! User account is valid.';
        } else {
            $result_message = 'Credential validation failed. Invalid username or password.';
        }
    } else {
        $result_message = 'System error occurred during validation.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Admin - Credential Validator</title>
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
            max-width: 800px;
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
        
        .auth-section {
            margin-bottom: 30px;
        }
        
        .auth-section h3 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .auth-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
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
        
        .auth-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        
        .auth-btn:hover {
            transform: translateY(-1px);
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
        
        .success-indicator {
            background: #d1ecf1;
            color: #0c5460;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #17a2b8;
            text-align: center;
        }
        
        .success-indicator h4 {
            margin-top: 0;
            color: #0c5460;
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
        <h1>IT Admin - Credential Validator</h1>
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
                <h2>User Credential Validation Tool</h2>
                <p>Internal IT tool for validating user login credentials and troubleshooting authentication issues.</p>
            </div>
            
            <div class="instructions">
                <h4>Administrator Guide:</h4>
                <p>Use this tool to verify user credentials and diagnose login problems.</p>
                <ul>
                    <li>Enter the username and password provided by the user</li>
                    <li>The system will check credentials against our Active Directory</li>
                    <li>Use this for password reset requests and account verification</li>
                    <li>Results will show if the credentials are valid or invalid</li>
                </ul>
            </div>
            
            <div class="auth-section">
                <h3>Credential Verification</h3>
                <form method="POST" action="" class="auth-form">
                    <div class="form-group">
                        <label for="test_username">Username:</label>
                        <input type="text" id="test_username" name="test_username" placeholder="Enter user's login name" value="<?php echo isset($_POST['test_username']) ? htmlspecialchars($_POST['test_username']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="test_password">Password:</label>
                        <input type="text" id="test_password" name="test_password" placeholder="Enter user's password" value="<?php echo isset($_POST['test_password']) ? htmlspecialchars($_POST['test_password']) : ''; ?>" required>
                    </div>
                    
                    <button type="submit" class="auth-btn">Validate Credentials</button>
                </form>
            </div>
            
            <?php if ($result_message): ?>
                <div class="result-section">
                    <div class="result-message <?php echo $login_success ? 'success' : 'error'; ?>">
                        <?php echo htmlspecialchars($result_message); ?>
                    </div>
                    
                    <?php if ($login_success): ?>
                        <div class="success-indicator">
                            <h4>✅ Credentials Valid!</h4>
                            <p>The user account has been verified and credentials are correct.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 