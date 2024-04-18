#!/bin/bash

base_url="http://localhost:8080/api/"
laravel_endpoints=("collectors/collect" "collectors/upgrade")

jwt="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0IiwiaWQiOjEsImlhdCI6MTcxMzM3MDQ1NSwiZXhwIjoxNzE1OTk4NDU1fQ.U0R7Qt3blxK6Pjilm0HBNYX41QYwC0CDVrXKKHyXShI"


# Make 3 HTTP requests with the bearer token
for i in {0..1}; do
    api_endpoint="${base_url}${laravel_endpoints[i]}"
    headers="Authorization:Bearer ${jwt}"
    # Make the HTTP request with cURL
    response=$(curl -s -X PATCH \
    -H "Content-Type: application/json" \
    -H "$headers" \
     -d "{\"id\": 1}" \
    "$api_endpoint")
    # Display the response for each request
    echo response
done

