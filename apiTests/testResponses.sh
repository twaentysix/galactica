#!/bin/bash

bearer_token=$1

base_url="http://localhost:8080/api/"
laravel_endpoints=("bases")

jwt="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0IiwiaWQiOjEsImlhdCI6MTcxMjA4OTc0MywiZXhwIjoxNzE0NzE3NzQzfQ.N653AMZ9eApwjxjBNhxnRu6WjQdfMmvb307G_S_I5l4"


# Make 3 HTTP requests with the bearer token
for i in {0..0}; do
    api_endpoint="${base_url}${laravel_endpoints[i]}"
    headers="Authorization:Bearer ${jwt}"
    # Make the HTTP request with cURL
    response=$(curl -s -X GET \
    -H "Content-Type: application/json" \
    -H "$headers" \
    "$api_endpoint")
    # Display the response for each request
done
