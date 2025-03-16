#!/bin/bash

# Define the .env file path
ENV_FILE=".env"

# Ensure the .env file exists
if [ ! -f "$ENV_FILE" ]; then
    echo ".env file not found!"
    # Copy the environment file
    docker exec -it project-management cp .env.example .env
fi

# Start Docker containers
docker compose up --build -d

# Install Composer dependencies
docker exec -it project-management composer install

# Generate application key
docker exec -it project-management php artisan key:generate --force

# Link storage
docker exec -it project-management php artisan storage:link --force

# Run migrations and seed the database
docker exec -it project-management php artisan migrate:fresh --force
docker exec -it project-management php artisan db:seed --force

echo "Setup completed successfully."

echo "Open http://localhost:8006"
echo "username: test"
echo "password: 123"