# 🏢 TechCorp IT Administration Portal - Docker Setup

A complete Docker environment for the TechCorp IT Administration Portal with MySQL database, PHP web server, and PHPMyAdmin.

## 🚀 Quick Start

### Prerequisites
- Docker Desktop installed and running
- Docker Compose installed
- At least 2GB free disk space
- Ports 8080, 8081, and 3306 available

### 1. Clone and Navigate
```bash
cd auth-test-env
```

### 2. Start the Environment
```bash
# Make scripts executable (Linux/Mac)
chmod +x start.sh stop.sh

# Start the environment
./start.sh
```

**Windows Users:**
```bash
docker-compose up --build -d
```

### 3. Access the Application
- **Web Application**: http://localhost:8080
- **Database Admin**: http://localhost:8081
- **Login**: admin / admin

## 📋 Services Overview

### 🌐 Web Server (Port 8080)
- **Container**: `auth_test_web`
- **Image**: Custom PHP 7.4 + Apache
- **Features**: MySQL extensions, session support, mod_rewrite
- **Volume**: Current directory mounted to `/var/www/html`

### 🗄️ Database (Port 3306)
- **Container**: `auth_test_db`
- **Image**: MySQL 5.7
- **Database**: `auth_test_security`
- **Auto-initialization**: Runs `setup_database.sql` on first start
- **Persistent Storage**: `mysql_data` volume

### 🔧 PHPMyAdmin (Port 8081)
- **Container**: `auth_test_phpmyadmin`
- **Image**: PHPMyAdmin latest
- **Purpose**: Database management interface
- **Access**: http://localhost:8081

## 🛠️ Management Commands

### Start Environment
```bash
./start.sh                    # Full startup with status info
docker-compose up -d          # Background start
docker-compose up             # Foreground start (see logs)
```

### Stop Environment
```bash
./stop.sh                     # Clean shutdown
docker-compose down           # Stop and remove containers
docker-compose down -v        # Stop and remove volumes (reset DB)
```

### View Logs
```bash
docker-compose logs -f webserver    # Web server logs
docker-compose logs -f database     # Database logs
docker-compose logs -f              # All logs
```

### Container Management
```bash
docker-compose ps                   # Show container status
docker-compose restart webserver    # Restart web server
docker-compose exec webserver bash  # Access web server shell
docker-compose exec database mysql -u root -p  # Access MySQL
```

## 🗃️ Database Information

### Connection Details
- **Host**: localhost (or `database` from containers)
- **Port**: 3306
- **Database**: auth_test_security
- **Username**: root
- **Password**: rootpassword

### Tables Created
- `users` - Employee directory (15 employees)
- `emails` - Employee contact information
- `departments` - Organizational structure
- `uagents` - System access logs
- `referers` - Web traffic analytics

### Sample Data
- **Admin Account**: admin / admin
- **Employees**: John.Smith, Sarah.Johnson, Mike.Wilson, etc.
- **Departments**: IT, HR, Finance, Marketing, Operations, etc.
- **Realistic Corporate Data**: Professional names, emails, positions

## 🔧 Configuration Files

### Docker Configuration
- `docker-compose.yml` - Main orchestration file
- `Dockerfile` - Custom web server image
- `docker/php.ini` - PHP configuration
- `docker/apache-config.conf` - Apache virtual host

### Application Files
- `setup_database.sql` - Database initialization
- `index.php` - Login page
- `dashboard.php` - Main portal
- `labs/` - Testing tools directory

## 🚨 Troubleshooting

### Common Issues

**Port Already in Use**
```bash
# Check what's using the port
netstat -tulpn | grep :8080
# Kill the process or change ports in docker-compose.yml
```

**Database Connection Failed**
```bash
# Wait for database to fully initialize
docker-compose logs database
# Look for "ready for connections" message
```

**Permission Denied**
```bash
# Fix file permissions
sudo chown -R $USER:$USER .
chmod +x start.sh stop.sh
```

**Container Won't Start**
```bash
# Check container logs
docker-compose logs webserver
# Rebuild containers
docker-compose up --build --force-recreate
```

### Reset Environment
```bash
# Complete reset (removes all data)
docker-compose down -v --rmi all
docker system prune -f
./start.sh
```

## 🔒 Security Notes

⚠️ **Important**: This environment contains intentional vulnerabilities for testing purposes.

- **Never deploy to production**
- **Use only in isolated environments**
- **Default passwords are intentionally weak**
- **SQL injection vulnerabilities are present by design**
- **Use for authorized testing only**

## 📊 Monitoring

### Health Checks
- Database health check included
- Web server dependency on database
- Automatic restart policies

### Log Files
- Apache logs: `/var/log/apache2/`
- PHP logs: `/var/log/php/`
- Application logs: `./logs/`

## 🎯 Testing Scenarios

### Available Tools
1. **Employee Directory** - User lookup functionality
2. **Credential Validator** - Authentication testing
3. **Session Manager** - Cookie-based sessions

### Test Accounts
- **admin/admin** - Administrative access
- **John.Smith/Welcome123** - IT Department
- **Sarah.Johnson/Password2024** - HR Manager
- **Mike.Wilson/TempPass456** - Finance

## 📞 Support

### Useful Commands
```bash
# View all containers
docker ps -a

# Check disk usage
docker system df

# Clean up unused resources
docker system prune

# Export database
docker-compose exec database mysqldump -u root -p auth_test_security > backup.sql

# Import database
docker-compose exec -T database mysql -u root -p auth_test_security < backup.sql
```

### Environment Variables
- `MYSQL_ROOT_PASSWORD=rootpassword`
- `MYSQL_DATABASE=auth_test_security`
- `DB_HOST=database`
- `DB_USER=root`

---

**Happy Testing! 🧪** 