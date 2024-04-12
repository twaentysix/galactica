#!/bin/bash

laravel_base_url="http://localhost:8080/api/"

laravel_endpoints=("auth/login")
filenames=("jwtToken")

key1="Joriex"
key2="password"
payload="{\"name\":\"$key1\",\"password\":\"$key2\"}"

# Make 3 HTTP requests with the bearer token
for i in {0..0};       do
    api_endpoint="${laravel_base_url}${laravel_endpoints[i]}"
    # Make the HTTP request with cURL
    response=$(curl -s -X POST \
    -H "Content-Type: application/json" \
    -d "$payload" \
    "$api_endpoint")
    echo "$response"
done
