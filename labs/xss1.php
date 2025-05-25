<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$username = $_SESSION['username'];
$search_query = '';
$search_results = [];

// Handle search functionality
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    
    // Log the request for analysis
    $fp = fopen('xss1_requests.txt', 'a');
    fwrite($fp, 'Search: ' . $search_query . " - User: " . $username . " - Time: " . date('Y-m-d H:i:s') . "\n");
    fclose($fp);
    
    // Simulate search results (vulnerable to XSS - no filtering)
    if (!empty($search_query)) {
        $search_results = [
            ['name' => 'John Smith', 'department' => 'IT', 'email' => 'john.smith@techcorp.com'],
            ['name' => 'Sarah Johnson', 'department' => 'HR', 'email' => 'sarah.johnson@techcorp.com'],
            ['name' => 'Mike Wilson', 'department' => 'Finance', 'email' => 'mike.wilson@techcorp.com']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Search Portal</title>
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
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .search-form button:hover {
            transform: translateY(-1px);
        }
        
        .search-results {
            margin-top: 30px;
        }
        
        .search-info {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #495057;
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .results-table th,
        .results-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .results-table th {
            background: #f8f9fa;
            font-weight: bold;
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
        <h1>Employee Search Portal</h1>
        <div class="nav-links">
            <span>Welcome, <?php echo htmlspecialchars($username); ?>!</span>
            <a href="../xss-challenges.php">Back to Tools</a>
            <a href="../dashboard.php">Dashboard</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="lab-container">
            <div class="lab-header">
                <h2>Global Employee Search System</h2>
                <p>Search and locate employees across all departments and office locations worldwide.</p>
            </div>
            
            <div class="instructions">
                <h4>Search Instructions:</h4>
                <p>Use the search function to find employees by name, department, or other criteria.</p>
                <ul>
                    <li>Enter employee names, department codes, or keywords</li>
                    <li>Search results display contact information and department details</li>
                    <li>Use wildcards (*) for broader search results</li>
                    <li>All searches are logged for compliance and auditing purposes</li>
                </ul>
            </div>
            
            <div class="search-section">
                <h3>Employee Search</h3>
                <form method="GET" action="" class="search-form">
                    <input type="text" name="search" placeholder="Enter employee name, department, or keywords..." value="<?php echo $search_query; ?>" required>
                    <button type="submit">Search Directory</button>
                </form>
            </div>
            
            <?php if (isset($_GET['search'])): ?>
                <div class="search-results">
                    <div class="search-info">
                        <strong>Search Query:</strong> <?php echo $search_query; ?>
                        <br>
                        <strong>Results Found:</strong> <?php echo count($search_results); ?> employees
                        <br>
                        <strong>Search Time:</strong> <?php echo date('Y-m-d H:i:s'); ?>
                    </div>
                    
                    <?php if (!empty($search_results)): ?>
                        <table class="results-table">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Email Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($search_results as $employee): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($employee['name']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['department']); ?></td>
                                        <td><?php echo htmlspecialchars($employee['email']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No employees found matching your search criteria.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 