<?php
session_start();

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

$error_message = '';

// Handle login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($con, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_array($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error_message = 'Invalid username or password';
        }
    } else {
        $error_message = 'Please enter both username and password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Testing Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #666;
            margin: 0;
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
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .demo-credentials {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            border: 1px solid #bee5eb;
        }
        
        .demo-credentials h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        
        .demo-credentials p {
            margin: 5px 0;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Security Testing Portal</h1>
            <p>Please login to access the testing environment</p>
        </div>
        
        <?php if ($error_message): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
        
        <div class="demo-credentials">
            <h3>Demo Credentials:</h3>
            <p><strong>Username:</strong> admin</p>
            <p><strong>Password:</strong> admin</p>
        </div>
    </div>
    
    <div style="position: fixed; bottom: 15px; left: 50%; transform: translateX(-50%); color: rgba(255,255,255,0.8); font-size: 14px; font-family: Arial, sans-serif; text-align: center;">
        with <span style="color: #ff4757;">♥</span> from h.haroon
    </div>
</body>
</html> 