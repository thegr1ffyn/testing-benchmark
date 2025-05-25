<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Communication Hub</title>
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';">
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
            max-width: 1000px;
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
        
        .message-section {
            margin-bottom: 30px;
        }
        
        .message-section h3 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .message-form {
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
        
        .form-group input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #007bff;
        }
        
        .send-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #6f42c1 0%, #5a2d91 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        
        .send-btn:hover {
            transform: translateY(-1px);
        }
        
        .message-display {
            margin-top: 30px;
            background: #e9ecef;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #6f42c1;
        }
        
        .message-display h4 {
            margin-top: 0;
            color: #333;
        }
        
        .message-content {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
            border: 1px solid #ddd;
            min-height: 50px;
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
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #bee5eb;
            margin-bottom: 20px;
        }
        
        .security-notice h5 {
            margin-top: 0;
            color: #0c5460;
        }
        
        .url-display {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            color: #666;
            margin-top: 10px;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Internal Communication Hub</h1>
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
                <h2>Enterprise Communication Platform</h2>
                <p>Secure internal messaging system for team collaboration and announcements.</p>
            </div>
            
            <div class="security-notice">
                <h5>🛡️ Advanced Security Features:</h5>
                <p>This platform implements Content Security Policy (CSP), input validation, and advanced filtering to prevent malicious content. All messages are processed through our enterprise security framework.</p>
            </div>
            
            <div class="instructions">
                <h4>Communication Guidelines:</h4>
                <p>Use this platform for internal team communications and announcements.</p>
                <ul>
                    <li>Messages support rich text formatting and special characters</li>
                    <li>All communications are encrypted and logged for compliance</li>
                    <li>Advanced security filtering protects against malicious content</li>
                    <li>URL sharing and link previews are supported</li>
                    <li>Messages are processed client-side for optimal performance</li>
                </ul>
            </div>
            
            <div class="message-section">
                <h3>Send Internal Message</h3>
                <form class="message-form" onsubmit="return sendMessage(event)">
                    <div class="form-group">
                        <label for="message">Message Content:</label>
                        <input type="text" id="message" name="message" placeholder="Enter your message or announcement..." required>
                    </div>
                    
                    <button type="submit" class="send-btn">Send Message</button>
                </form>
                
                <div class="url-display">
                    <strong>Current URL:</strong> <span id="current-url"></span>
                </div>
            </div>
            
            <div class="message-display" id="message-output" style="display: none;">
                <h4>📨 Message Sent Successfully</h4>
                <p><strong>From:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>Timestamp:</strong> <span id="timestamp"></span></p>
                <p><strong>Status:</strong> Delivered</p>
                
                <div class="message-content" id="message-content">
                    <!-- Message content will be displayed here -->
                </div>
                
                <p style="margin-top: 15px; color: #666; font-size: 14px;">
                    <em>Message has been processed and delivered to the internal communication system.</em>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Update current URL display
        document.getElementById('current-url').textContent = window.location.href;
        
        // Advanced input filtering function
        function sanitizeInput(input) {
            // Advanced filtering - can still be bypassed with DOM manipulation
            let filtered = input;
            
            // Remove common XSS patterns
            filtered = filtered.replace(/<script[^>]*>.*?<\/script>/gi, '');
            filtered = filtered.replace(/javascript:/gi, '');
            filtered = filtered.replace(/on\w+\s*=/gi, '');
            filtered = filtered.replace(/<iframe[^>]*>.*?<\/iframe>/gi, '');
            filtered = filtered.replace(/<object[^>]*>.*?<\/object>/gi, '');
            filtered = filtered.replace(/<embed[^>]*>/gi, '');
            
            return filtered;
        }
        
        // Send message function (DOM-based XSS vulnerability)
        function sendMessage(event) {
            event.preventDefault();
            
            const messageInput = document.getElementById('message');
            const messageOutput = document.getElementById('message-output');
            const messageContent = document.getElementById('message-content');
            const timestamp = document.getElementById('timestamp');
            
            let message = messageInput.value;
            
            // Log the message (for analysis)
            console.log('Message sent:', message);
            
            // Apply "advanced" filtering
            message = sanitizeInput(message);
            
            // Set timestamp
            timestamp.textContent = new Date().toLocaleString();
            
            // Display the message (vulnerable to DOM XSS)
            messageContent.innerHTML = '<strong>Message:</strong><br>' + message;
            
            // Show the output
            messageOutput.style.display = 'block';
            
            // Scroll to output
            messageOutput.scrollIntoView({ behavior: 'smooth' });
            
            // Clear the form
            messageInput.value = '';
            
            return false;
        }
        
        // Check for URL parameters and auto-populate (DOM XSS vector)
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const messageParam = urlParams.get('message');
            
            if (messageParam) {
                document.getElementById('message').value = decodeURIComponent(messageParam);
                // Auto-send if message parameter is present
                setTimeout(() => {
                    sendMessage({ preventDefault: () => {} });
                }, 500);
            }
        };
    </script>
</body>
</html> 