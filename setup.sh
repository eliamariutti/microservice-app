#!/bin/bash

# Check if Docker Compose is installed
if command -v docker compose &> /dev/null
then
    echo "Docker Compose found. Continuing..."
else
    echo "Docker Compose not found. Please install Docker Compose and try again."
    exit 1
fi

# Copy .env file
cp .env_microservice .env

# Build Docker Compose services
docker compose build

# Install dependencies using Composer
docker compose run laravel.test composer install

if [ -f ./vendor/bin/sail ]
then
    echo "Starting the application..."
else
    echo "Sail script not found. Oh gosh"
    exit 1
fi

# Start the application
./vendor/bin/sail up -d
