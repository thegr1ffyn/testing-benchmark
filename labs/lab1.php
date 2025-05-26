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
$user_data = null;

// Handle user lookup
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Log the request for analysis
    $fp = fopen('lab1_requests.txt', 'a');
    fwrite($fp, 'ID: ' . $id . " - User: " . $username . " - Time: " . date('Y-m-d H:i:s') . "\n");
    fclose($fp);
    
    // Record start time for detecting time-based attacks
    $start_time = microtime(true);
    
    // Vulnerable SQL query (same as Less-10) - Time-based blind injection
    $id = '"' . $id . '"';
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 0,1";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    
    // Calculate execution time
    $execution_time = microtime(true) - $start_time;
    
    // Always show "Access granted" message (blind injection behavior)
    $result_message = 'Employee directory access granted. Search completed successfully.';
    
    // Detect potential time-based injection attempts
    if ($execution_time > 2.0) {
        $result_message .= ' [SLOW QUERY DETECTED - ' . round($execution_time, 2) . 's]';
        $time_attack_detected = true;
    } else {
        $time_attack_detected = false;
    }
    
    // For legitimate queries, show actual data if found
    if ($row && !preg_match('/sleep|benchmark|waitfor/i', $_GET['id'])) {
        $user_data = $row;
    } else {
        $user_data = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Directory - Advanced Search</title>
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
        
        .search-section {
            margin-bottom: 30px;
        }
        
        .search-section h3 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .search-form input[type="text"] {
            flex: 1;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .search-form button {
            padding: 12px 24px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .search-form button:hover {
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
        
        .result-message.warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .security-alert {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #dc3545;
            margin-top: 20px;
        }
        
        .security-alert h4 {
            margin-top: 0;
            color: #721c24;
        }
        
        .security-alert ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        .security-alert li {
            margin: 5px 0;
            color: #721c24;
        }
        
        .user-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        
        .user-info h4 {
            margin-top: 0;
            color: #333;
        }
        
        .user-info p {
            margin: 8px 0;
            color: #555;
        }
        
        .user-info strong {
            color: #333;
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
        <h1>Employee Directory - Advanced Search</h1>
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
                <h2>Advanced Employee Directory System</h2>
                <p>High-performance employee lookup system with advanced query processing capabilities.</p>
            </div>
            
            <div class="instructions">
                <h4>How to Use:</h4>
                <p>Enter an employee ID to retrieve their profile information from our HR database.</p>
                <ul>
                    <li>Employee IDs are numeric values assigned during onboarding</li>
                    <li>System uses advanced query optimization for fast lookups</li>
                    <li>All database queries are logged for security monitoring</li>
                    <li>Contact IT support if you encounter any system errors</li>
                </ul>
            </div>
            
            <div class="search-section">
                <h3>Employee Profile Search</h3>
                <form method="GET" action="" class="search-form">
                    <input type="text" name="id" placeholder="Enter Employee ID (e.g., 1)" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>" required>
                    <button type="submit">Search Employee</button>
                </form>
            </div>
            
            <?php if ($result_message): ?>
                <div class="result-section">
                    <div class="result-message <?php echo isset($time_attack_detected) && $time_attack_detected ? 'warning' : 'success'; ?>">
                        <?php echo htmlspecialchars($result_message); ?>
                    </div>
                    
                    <?php if (isset($time_attack_detected) && $time_attack_detected): ?>
                        <div class="security-alert">
                            <h4>⚠️ Security Notice:</h4>
                            <p>Unusual query execution time detected. This may indicate:</p>
                            <ul>
                                <li>Database performance issues</li>
                                <li>Complex query operations</li>
                                <li>Potential security testing activity</li>
                            </ul>
                            <p><strong>Incident logged for security review.</strong></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($user_data): ?>
                        <div class="user-info">
                            <h4>Employee Profile:</h4>
                            <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($user_data['id']); ?></p>
                            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user_data['username']); ?></p>
                            <p><strong>System Password:</strong> <?php echo htmlspecialchars($user_data['password']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 