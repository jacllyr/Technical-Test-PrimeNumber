#!/bin/bash

echo "Waiting for services to start..."

# Start services
docker-compose up -d

# Wait for services to start
echo "Please allow 5 seconds to test the PRIME NUMBER script..."

sleep 5

# Test the form submission
RESULT=$(curl --request GET \
  --url 'http://localhost:4000/logic.php?primeNumber=5000' \
  --header 'Content-type: application/x-www-form-urlencoded')

echo "Result is $RESULT and we expect PRIME NUMBER 5000"

sleep 3

echo "Now testing the pagination for page 5."

sleep 5

# Test the pagination result.
RESULT=$(curl --request GET \
  --url 'http://localhost:4000/logic.php?primeNumber=5000&page=5' \
  --header 'Content-type: application/x-www-form-urlencoded')

echo "Result is $RESULT and we expect PRIME NUMBER 5000 with current page 5."

sleep 3

echo "Shutting services down gracefully..."

sleep 10

# Stop services
docker-compose down
