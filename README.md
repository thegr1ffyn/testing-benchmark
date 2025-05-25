# Authentication Testing Environment

A comprehensive web application testing environment that includes SQL injection vulnerabilities behind authentication barriers.

## Overview

This testing environment provides:
- Authentication-protected vulnerabilities
- Realistic scenarios without obvious vulnerability hints
- Multiple SQL injection labs based on SQLi-Labs Less-1, Less-16, and Less-21
- Professional interface

## Setup Instructions

### Database Setup
1. Import the database schema:
   ```bash
   mysql -u root -p < setup_database.sql
   ```

### Access the Application
1. Navigate to `http://localhost/auth-test-env/`
2. Login with: admin / admin

## Labs Available

1. **Lab 1 - User Information Lookup** (Based on Less-1)
2. **Lab 2 - Authentication System** (Based on Less-16)  
3. **Lab 3 - Session Management** (Based on Less-21)

## Security Warning

⚠️ This application contains intentional vulnerabilities. Use only in isolated testing environments. 