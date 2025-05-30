<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Testing Labs</title>
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
            border-top: 4px solid #e74c3c;
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
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Database Testing Labs</h1>
        <div class="nav-links">
            <span>Welcome, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="page-header">
            <h2>Database Management Tools</h2>
            <p>Access our suite of database management and user administration tools. These applications help you manage user accounts, verify credentials, and maintain system sessions.</p>
        </div>
        
        <div class="labs-grid">
            <div class="lab-card">
                <div class="difficulty beginner">BASIC</div>
                <h3>Employee Directory</h3>
                <p>Search and retrieve employee information from our company database. Enter an employee ID to view their profile details and contact information.</p>
                <a href="labs/lab1.php" class="lab-btn">Access Directory</a>
            </div>
            
            <div class="lab-card">
                <div class="difficulty intermediate">STANDARD</div>
                <h3>Credential Validator</h3>
                <p>Internal tool for IT administrators to validate user credentials and test login functionality. Verify username and password combinations against our user database.</p>
                <a href="labs/lab2.php" class="lab-btn">Open Validator</a>
            </div>
            
            <div class="lab-card">
                <div class="difficulty advanced">ENTERPRISE</div>
                <h3>Session Manager</h3>
                <p>Advanced session management portal for administrators. Create and manage user sessions, monitor active tokens, and maintain secure authentication states.</p>
                <a href="labs/lab3.php" class="lab-btn">Launch Manager</a>
            </div>
        </div>
    </div>
</body>
</html> 