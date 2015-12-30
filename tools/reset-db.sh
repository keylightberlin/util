#!/bin/bash
if [ -z "$1" ]; then
    environment="dev"
else
    environment=$1
fi
echo "Dropping database with environment $environment..."
php app/console do:da:dr --force --env=$environment
echo "Creating database..."
php app/console do:da:cr --env=$environment
echo "Setting up schema..."
php app/console do:sch:up --force --env=$environment
echo "Done"
