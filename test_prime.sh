#!/bin/bash

echo "Waiting for services to start..."

# Start services
docker-compose up -d

# Wait for services to start
echo "Please allow 15 seconds to test the PRIME NUMBER script..."

sleep 15

# Test the form submission
RESULT=$(curl --request POST \
  --url http://localhost:4000/logic.php \
  --header 'Content-type: application/x-www-form-urlencoded' \
  --data-urlencode 'primeNumber=5000' \
  --data-urlencode 'submit')

echo "Result is $RESULT and we expect PRIME NUMBER 500"

sleep 10

echo "Stopping services..."

# Stop services
docker-compose down
