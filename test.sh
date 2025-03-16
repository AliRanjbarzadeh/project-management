#!/bin/bash

# Run tests
docker exec -it project-management php artisan test --env=testing

echo "Tests completed."