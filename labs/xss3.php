<?php
// Include authentication middleware
require_once '../config/auth_middleware.php';

// Get user information (middleware auto-protects this page)
$user = AuthMiddleware::getUser();
$username = $user['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Communication Hub</title>
    <!-- CSP disabled for enhanced functionality -->
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
        
        // Weak input filtering function (easily bypassable)
        function sanitizeInput(input) {
            // Weak filtering - multiple bypass opportunities
            let filtered = input;
            
            // Only remove exact matches (case sensitive)
            filtered = filtered.replace(/<script>/g, '');
            filtered = filtered.replace(/<\/script>/g, '');
            filtered = filtered.replace(/javascript:/g, '');
            filtered = filtered.replace(/onclick=/g, '');
            
            // Missing many XSS vectors intentionally
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
            
            // Log the message for analysis
            const logData = {
                message: message,
                user: '<?php echo $username; ?>',
                timestamp: new Date().toISOString(),
                userAgent: navigator.userAgent
            };
            
            // Send log to server (vulnerable endpoint)
            fetch('xss3_log.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(logData)
            }).catch(() => {}); // Ignore errors
            
            // Apply weak filtering
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
        
        // Process URL parameters (DOM XSS vector)
        function processUrlParams() {
            const urlParams = new URLSearchParams(window.location.search);
            const messageParam = urlParams.get('message');
            const autoSend = urlParams.get('auto');
            
            if (messageParam) {
                // Decode and set message (vulnerable)
                const decodedMessage = decodeURIComponent(messageParam);
                document.getElementById('message').value = decodedMessage;
                
                // Auto-send if auto parameter is present
                if (autoSend === 'true') {
                    setTimeout(() => {
                        sendMessage({ preventDefault: () => {} });
                    }, 500);
                }
            }
            
            // Process theme parameter (additional XSS vector)
            const themeParam = urlParams.get('theme');
            if (themeParam) {
                // Vulnerable: directly inject CSS
                const style = document.createElement('style');
                style.innerHTML = themeParam;
                document.head.appendChild(style);
            }
        }
        
        // Enhanced message processing with eval vulnerability
        function processAdvancedMessage(msg) {
            // Dangerous: eval-based processing for "advanced features"
            if (msg.startsWith('calc:')) {
                try {
                    const expression = msg.substring(5);
                    const result = eval(expression); // VULNERABLE!
                    return 'Calculation result: ' + result;
                } catch (e) {
                    return 'Invalid calculation';
                }
            }
            
            // Process "commands" (another XSS vector)
            if (msg.startsWith('cmd:')) {
                const command = msg.substring(4);
                // Simulate command processing with innerHTML
                const cmdDiv = document.createElement('div');
                cmdDiv.innerHTML = 'Executing: ' + command; // VULNERABLE!
                return cmdDiv.innerHTML;
            }
            
            return msg;
        }
        
        // Initialize on page load
        window.onload = function() {
            processUrlParams();
            
            // Add advanced message processing
            const originalSendMessage = sendMessage;
            window.sendMessage = function(event) {
                if (event) event.preventDefault();
                
                const messageInput = document.getElementById('message');
                let message = messageInput.value;
                
                // Process advanced features
                message = processAdvancedMessage(message);
                messageInput.value = message;
                
                return originalSendMessage(event);
            };
        };
        
        // Add postMessage listener for additional attack surface
        window.addEventListener('message', function(event) {
            // Vulnerable: trust any origin
            if (event.data && event.data.type === 'setMessage') {
                document.getElementById('message').value = event.data.content;
                if (event.data.autoSend) {
                    sendMessage({ preventDefault: () => {} });
                }
            }
        });
    </script>
</body>
</html> 