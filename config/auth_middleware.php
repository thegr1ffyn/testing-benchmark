<?php
/**
 * Authentication Middleware
 * Handles authentication checks and redirects based on user status
 */

// Include session configuration first
require_once __DIR__ . '/session_config.php';

class AuthMiddleware {
    
    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Get current page name without extension
     */
    public static function getCurrentPage() {
        return basename($_SERVER['PHP_SELF'], '.php');
    }
    
    /**
     * Get the correct redirect path based on current location
     */
    public static function getRedirectPath($target) {
        $current_dir = dirname($_SERVER['PHP_SELF']);
        
        // If we're in a subdirectory (like /labs/), adjust the path
        if (strpos($current_dir, '/labs') !== false) {
            return '../' . $target;
        }
        
        return $target;
    }
    
    /**
     * Require authentication - redirect to login if not authenticated
     */
    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            $redirect_path = self::getRedirectPath('index.php');
            header('Location: ' . $redirect_path);
            exit();
        }
    }
    
    /**
     * Require guest (not authenticated) - redirect to dashboard if authenticated
     */
    public static function requireGuest() {
        if (self::isAuthenticated()) {
            $redirect_path = self::getRedirectPath('dashboard.php');
            header('Location: ' . $redirect_path);
            exit();
        }
    }
    
    /**
     * Auto-redirect based on authentication status and current page
     */
    public static function autoRedirect() {
        $current_page = self::getCurrentPage();
        $is_authenticated = self::isAuthenticated();
        
        // Pages that require authentication
        $protected_pages = [
            'dashboard',
            'sql-challenges', 
            'xss-challenges',
            'session_test',
            'lab1', 'lab2', 'lab3',
            'xss1', 'xss2', 'xss3', 'xss3_log'
        ];
        
        // Pages that should redirect authenticated users
        $guest_only_pages = [
            'index'
        ];
        
        // Check if current page requires authentication
        if (in_array($current_page, $protected_pages)) {
            self::requireAuth();
        }
        
        // Check if current page should redirect authenticated users
        if (in_array($current_page, $guest_only_pages)) {
            self::requireGuest();
        }
    }
    
    /**
     * Get user information if authenticated
     */
    public static function getUser() {
        if (self::isAuthenticated()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'login_time' => $_SESSION['login_time'] ?? null,
                'last_activity' => $_SESSION['last_activity'] ?? null
            ];
        }
        return null;
    }
    
    /**
     * Set user session data after successful login
     */
    public static function login($user_data) {
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['last_activity'] = time();
        $_SESSION['login_time'] = time();
        
        // Regenerate session ID for security
        session_regenerate_id(true);
    }
    
    /**
     * Clear user session data
     */
    public static function logout() {
        // Clear session data
        session_unset();
        session_destroy();
        
        // Clear session cookie
        setcookie('AUTH_TEST_SESSION', '', time() - 3600, '/');
        
        // Start a new session for flash messages
        session_start();
    }
    
    /**
     * Check session timeout and handle expiration
     */
    public static function checkSessionTimeout() {
        if (self::isAuthenticated() && isset($_SESSION['last_activity'])) {
            $session_timeout = 3600; // 1 hour
            
            if (time() - $_SESSION['last_activity'] > $session_timeout) {
                self::logout();
                
                // Redirect to login with expiration message
                $redirect_path = self::getRedirectPath('index.php?expired=1');
                header('Location: ' . $redirect_path);
                exit();
            }
        }
    }
    
    /**
     * Initialize middleware - call this at the beginning of each page
     */
    public static function init($page_type = 'auto') {
        // Check session timeout first
        self::checkSessionTimeout();
        
        // Handle different page types
        switch ($page_type) {
            case 'protected':
                self::requireAuth();
                break;
            case 'guest':
                self::requireGuest();
                break;
            case 'auto':
            default:
                self::autoRedirect();
                break;
        }
    }
}

// Auto-initialize middleware if not called explicitly
if (!defined('AUTH_MIDDLEWARE_MANUAL')) {
    AuthMiddleware::init();
}
?> 