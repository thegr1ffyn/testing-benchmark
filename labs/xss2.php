<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$username = $_SESSION['username'];
$comment = '';
$comment_submitted = false;

// Handle comment submission
if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    
    // Log the request for analysis
    $fp = fopen('xss2_requests.txt', 'a');
    fwrite($fp, 'Comment: ' . $comment . " - User: " . $username . " - Time: " . date('Y-m-d H:i:s') . "\n");
    fclose($fp);
    
    // Basic XSS filtering (can be bypassed) - Medium difficulty
    $comment = str_replace('<script>', '', $comment);
    $comment = str_replace('</script>', '', $comment);
    $comment = str_replace('javascript:', '', $comment);
    $comment = str_replace('onclick', '', $comment);
    
    $comment_submitted = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Feedback System</title>
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
        
        .feedback-section {
            margin-bottom: 30px;
        }
        
        .feedback-section h3 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .feedback-form {
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
        
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            min-height: 120px;
            resize: vertical;
        }
        
        .form-group textarea:focus {
            outline: none;
            border-color: #007bff;
        }
        
        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        
        .submit-btn:hover {
            transform: translateY(-1px);
        }
        
        .comment-display {
            margin-top: 30px;
            background: #e9ecef;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #17a2b8;
        }
        
        .comment-display h4 {
            margin-top: 0;
            color: #333;
        }
        
        .comment-content {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            border: 1px solid #ddd;
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
        
        .security-notice {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ffeaa7;
            margin-bottom: 20px;
        }
        
        .security-notice h5 {
            margin-top: 0;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Employee Feedback System</h1>
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
                <h2>Employee Feedback & Suggestion Portal</h2>
                <p>Submit feedback, suggestions, and comments to help improve our workplace environment.</p>
            </div>
            
            <div class="security-notice">
                <h5>🔒 Content Security Notice:</h5>
                <p>All submissions are automatically filtered for security. Malicious content including scripts and harmful code will be removed to protect our systems.</p>
            </div>
            
            <div class="instructions">
                <h4>Feedback Guidelines:</h4>
                <p>Please use this portal to submit constructive feedback and suggestions.</p>
                <ul>
                    <li>Be specific and detailed in your feedback</li>
                    <li>Use professional language appropriate for workplace communication</li>
                    <li>Include suggestions for improvement where applicable</li>
                    <li>All feedback is reviewed by management and HR teams</li>
                    <li>Anonymous submissions are welcome and encouraged</li>
                </ul>
            </div>
            
            <div class="feedback-section">
                <h3>Submit Your Feedback</h3>
                <form method="POST" action="" class="feedback-form">
                    <div class="form-group">
                        <label for="comment">Your Feedback or Suggestion:</label>
                        <textarea id="comment" name="comment" placeholder="Enter your feedback, suggestions, or comments here..." required></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Submit Feedback</button>
                </form>
            </div>
            
            <?php if ($comment_submitted): ?>
                <div class="comment-display">
                    <h4>📝 Feedback Submitted Successfully</h4>
                    <p><strong>Submitted by:</strong> <?php echo htmlspecialchars($username); ?></p>
                    <p><strong>Submission Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
                    <p><strong>Status:</strong> Under Review</p>
                    
                    <div class="comment-content">
                        <strong>Your Feedback:</strong><br>
                        <?php echo $comment; ?>
                    </div>
                    
                    <p style="margin-top: 15px; color: #666; font-size: 14px;">
                        <em>Thank you for your feedback. Your submission has been logged and will be reviewed by the appropriate team members.</em>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 