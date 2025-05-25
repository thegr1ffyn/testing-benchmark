-- Database setup for Corporate IT Administration Portal
-- This creates the database and tables needed for the enterprise management system

DROP DATABASE IF EXISTS auth_test_security;
CREATE DATABASE auth_test_security;
USE auth_test_security;

-- Create employee directory table
CREATE TABLE users (
    id int(3) NOT NULL AUTO_INCREMENT,
    username varchar(20) NOT NULL,
    password varchar(20) NOT NULL,
    department varchar(30) DEFAULT 'General',
    position varchar(40) DEFAULT 'Employee',
    hire_date DATE DEFAULT '2020-01-01',
    PRIMARY KEY (id)
);

-- Create employee contact information table
CREATE TABLE emails (
    id int(3) NOT NULL AUTO_INCREMENT,
    email_id varchar(30) NOT NULL,
    department varchar(30) DEFAULT 'General',
    PRIMARY KEY (id)
);

-- Create system access logs table
CREATE TABLE uagents (
    id int(3) NOT NULL AUTO_INCREMENT,
    uagent varchar(256) NOT NULL,
    ip_address varchar(35) NOT NULL,
    username varchar(20) NOT NULL,
    access_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Create web traffic analytics table
CREATE TABLE referers (
    id int(3) NOT NULL AUTO_INCREMENT,
    referer varchar(256) NOT NULL,
    ip_address varchar(35) NOT NULL,
    page_accessed varchar(100) DEFAULT '/',
    visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Insert employee directory data
INSERT INTO auth_test_security.users (id, username, password, department, position, hire_date) VALUES 
('1', 'John.Smith', 'Welcome123', 'IT Department', 'System Administrator', '2019-03-15'), 
('2', 'Sarah.Johnson', 'Password2024', 'Human Resources', 'HR Manager', '2018-07-22'), 
('3', 'Mike.Wilson', 'TempPass456', 'Finance', 'Financial Analyst', '2021-01-10'), 
('4', 'Lisa.Brown', 'Secure789', 'Marketing', 'Marketing Coordinator', '2020-09-05'), 
('5', 'David.Garcia', 'Access2023', 'Operations', 'Operations Manager', '2017-11-30'), 
('6', 'Emma.Davis', 'Login999', 'IT Department', 'Database Administrator', '2022-02-14'), 
('7', 'James.Miller', 'Auth2024', 'Security', 'Security Analyst', '2019-08-18'), 
('8', 'admin', 'admin', 'IT Department', 'System Administrator', '2015-01-01'),
('9', 'Jennifer.Taylor', 'Pass123!', 'Legal', 'Legal Counsel', '2020-04-12'),
('10', 'Robert.Anderson', 'Work2024', 'Sales', 'Sales Director', '2018-12-03'),
('11', 'Maria.Rodriguez', 'Staff456', 'Customer Service', 'Support Manager', '2021-06-20'),
('12', 'Thomas.Wilson', 'Corp789', 'Engineering', 'Senior Engineer', '2019-10-08'),
('13', 'Ashley.Moore', 'Team2023', 'Project Management', 'Project Manager', '2020-11-25'),
('14', 'Kevin.Jackson', 'Biz456!', 'Business Development', 'BD Manager', '2022-01-30'),
('15', 'Rachel.White', 'Office123', 'Administration', 'Office Manager', '2018-05-16');

-- Insert employee contact information
INSERT INTO auth_test_security.emails (id, email_id, department) VALUES 
('1', 'john.smith@techcorp.com', 'IT Department'), 
('2', 'sarah.johnson@techcorp.com', 'Human Resources'), 
('3', 'mike.wilson@techcorp.com', 'Finance'), 
('4', 'lisa.brown@techcorp.com', 'Marketing'), 
('5', 'david.garcia@techcorp.com', 'Operations'), 
('6', 'emma.davis@techcorp.com', 'IT Department'), 
('7', 'james.miller@techcorp.com', 'Security'), 
('8', 'admin@techcorp.com', 'IT Department'),
('9', 'jennifer.taylor@techcorp.com', 'Legal'),
('10', 'robert.anderson@techcorp.com', 'Sales'),
('11', 'maria.rodriguez@techcorp.com', 'Customer Service'),
('12', 'thomas.wilson@techcorp.com', 'Engineering'),
('13', 'ashley.moore@techcorp.com', 'Project Management'),
('14', 'kevin.jackson@techcorp.com', 'Business Development'),
('15', 'rachel.white@techcorp.com', 'Administration');

-- Insert sample system access logs
INSERT INTO auth_test_security.uagents (uagent, ip_address, username, access_time) VALUES 
('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '192.168.1.101', 'John.Smith', '2024-01-15 09:30:00'),
('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '192.168.1.102', 'Sarah.Johnson', '2024-01-15 08:45:00'),
('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101', '192.168.1.103', 'Mike.Wilson', '2024-01-15 10:15:00'),
('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36', '192.168.1.104', 'Lisa.Brown', '2024-01-15 11:20:00'),
('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '192.168.1.105', 'admin', '2024-01-15 07:30:00');

-- Insert sample web traffic data
INSERT INTO auth_test_security.referers (referer, ip_address, page_accessed, visit_time) VALUES 
('https://intranet.techcorp.com/dashboard', '192.168.1.101', '/employee-directory', '2024-01-15 09:35:00'),
('https://portal.techcorp.com/login', '192.168.1.102', '/credential-validator', '2024-01-15 08:50:00'),
('https://mail.techcorp.com', '192.168.1.103', '/session-manager', '2024-01-15 10:20:00'),
('https://docs.techcorp.com/policies', '192.168.1.104', '/employee-directory', '2024-01-15 11:25:00'),
('https://admin.techcorp.com', '192.168.1.105', '/database-tools', '2024-01-15 07:35:00'),
('https://support.techcorp.com/tickets', '192.168.1.106', '/credential-validator', '2024-01-15 14:10:00'),
('https://crm.techcorp.com/leads', '192.168.1.107', '/session-manager', '2024-01-15 13:45:00');

-- Create additional corporate tables for realism
CREATE TABLE departments (
    id int(3) NOT NULL AUTO_INCREMENT,
    dept_name varchar(50) NOT NULL,
    dept_head varchar(50) NOT NULL,
    budget decimal(10,2) DEFAULT 0.00,
    location varchar(30) DEFAULT 'Main Office',
    PRIMARY KEY (id)
);

-- Insert department information
INSERT INTO auth_test_security.departments (dept_name, dept_head, budget, location) VALUES 
('IT Department', 'John.Smith', 250000.00, 'Building A - Floor 3'),
('Human Resources', 'Sarah.Johnson', 180000.00, 'Building B - Floor 1'),
('Finance', 'Mike.Wilson', 320000.00, 'Building A - Floor 2'),
('Marketing', 'Lisa.Brown', 150000.00, 'Building C - Floor 1'),
('Operations', 'David.Garcia', 280000.00, 'Building A - Floor 1'),
('Security', 'James.Miller', 200000.00, 'Building A - Floor 4'),
('Legal', 'Jennifer.Taylor', 220000.00, 'Building B - Floor 3'),
('Sales', 'Robert.Anderson', 300000.00, 'Building C - Floor 2'),
('Customer Service', 'Maria.Rodriguez', 160000.00, 'Building B - Floor 2'),
('Engineering', 'Thomas.Wilson', 400000.00, 'Building A - Floor 5');

-- Display success message
SELECT 'Corporate database setup completed successfully!' as Status; 