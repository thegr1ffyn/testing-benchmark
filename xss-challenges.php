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
    <title>Script Testing Labs</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .page-header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
            text-align: center;
        }
        
        .page-header h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .page-header p {
            color: #666;
            font-size: 18px;
        }
        
        .labs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        
        .lab-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 4px solid #f39c12;
        }
        
        .lab-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .lab-card h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 22px;
        }
        
        .lab-card p {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        
        .lab-btn {
            display: inline-block;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s;
        }
        
        .lab-btn:hover {
            transform: translateY(-2px);
        }
        
        .difficulty {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .difficulty.beginner {
            background: #2ecc71;
            color: white;
        }
        
        .difficulty.intermediate {
            background: #f39c12;
            color: white;
        }
        
        .difficulty.advanced {
            background: #e74c3c;
            color: white;
        }
        
        .coming-soon {
            background: #ecf0f1;
            color: #7f8c8d;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            border-top: 4px solid #bdc3c7;
        }
        
        .coming-soon h3 {
            color: #7f8c8d;
            margin-bottom: 15px;
        }
        
        .coming-soon p {
            color: #95a5a6;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Script Testing Labs</h1>
        <div class="nav-links">
            <span>Welcome, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="page-header">
            <h2>Client-Side Security Testing</h2>
            <p>Explore various client-side security scenarios. Test how web applications handle user input and client-side script execution.</p>
        </div>
        
        <div class="labs-grid">
            <div class="lab-card">
                <div class="difficulty beginner">BASIC</div>
                <h3>Employee Search Portal</h3>
                <p>Global employee directory search system with real-time results. Test how the application processes and displays search queries across the organization.</p>
                <a href="labs/xss1.php" class="lab-btn">Access Search Portal</a>
            </div>
            
            <div class="lab-card">
                <div class="difficulty intermediate">STANDARD</div>
                <h3>Employee Feedback System</h3>
                <p>Internal feedback portal with advanced content filtering. Submit suggestions and feedback through our secure enterprise communication platform.</p>
                <a href="labs/xss2.php" class="lab-btn">Access Feedback Portal</a>
            </div>
            
            <div class="lab-card">
                <div class="difficulty advanced">ENTERPRISE</div>
                <h3>Internal Communication Hub</h3>
                <p>Enterprise messaging platform with CSP protection and advanced filtering. Secure internal communications with enterprise-grade security features.</p>
                <a href="labs/xss3.php" class="lab-btn">Access Communication Hub</a>
            </div>
        </div>
    </div>
</body>
</html> 