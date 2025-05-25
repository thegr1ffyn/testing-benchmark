#!/bin/bash

# TechCorp IT Administration Portal - Docker Startup Script
echo "🏢 Starting TechCorp IT Administration Portal..."
echo "=================================================="

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Error: Docker is not running. Please start Docker first."
    exit 1
fi

# Check if Docker Compose is available
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Error: Docker Compose is not installed."
    exit 1
fi

# Create logs directory if it doesn't exist
mkdir -p logs
chmod 777 logs

# Stop any existing containers
echo "🛑 Stopping existing containers..."
docker-compose down

# Build and start the containers
echo "🔨 Building and starting containers..."
docker-compose up --build -d

# Wait for database to be ready
echo "⏳ Waiting for database to initialize..."
sleep 30

# Check container status
echo "📊 Container Status:"
docker-compose ps

# Display access information
echo ""
echo "✅ TechCorp IT Administration Portal is now running!"
echo "=================================================="
echo "🌐 Web Application: http://localhost:8080"
echo "🗄️  Database Admin:  http://localhost:8081"
echo ""
echo "📋 Login Credentials:"
echo "   Username: admin"
echo "   Password: admin"
echo ""
echo "🗃️  Database Access:"
echo "   Host: localhost:3306"
echo "   Username: root"
echo "   Password: rootpassword"
echo "   Database: auth_test_security"
echo ""
echo "🛠️  Available Tools:"
echo "   • Employee Directory"
echo "   • Credential Validator" 
echo "   • Session Manager"
echo ""
echo "📝 Logs:"
echo "   docker-compose logs -f webserver"
echo "   docker-compose logs -f database"
echo ""
echo "🛑 To stop: docker-compose down"
echo "==================================================" 