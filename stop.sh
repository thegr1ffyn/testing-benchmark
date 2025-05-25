#!/bin/bash

# TechCorp IT Administration Portal - Docker Stop Script
echo "🛑 Stopping TechCorp IT Administration Portal..."
echo "=================================================="

# Stop and remove containers
echo "🔄 Stopping containers..."
docker-compose down

# Optional: Remove volumes (uncomment to reset database)
# echo "🗑️  Removing volumes..."
# docker-compose down -v

# Optional: Remove images (uncomment to clean up completely)
# echo "🧹 Removing images..."
# docker-compose down --rmi all

echo "✅ TechCorp IT Administration Portal stopped successfully!"
echo "==================================================" 