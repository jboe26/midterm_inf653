<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

echo json_encode([
    "message" => "Welcome to the Quotes REST API!",
    "endpoints" => [
        "GET /api/quotes/" => "Retrieve all quotes",
        "GET /api/quotes/?id=1" => "Retrieve a quote by ID",
        "GET /api/quotes/?author_id=2" => "Retrieve quotes by author ID",
        "GET /api/quotes/?category_id=3" => "Retrieve quotes by category ID",
        "GET /api/quotes/?random=true" => "Retrieve a random quote",
        "POST /api/quotes/" => "Create a new quote",
        "PUT /api/quotes/" => "Update an existing quote",
        "DELETE /api/quotes/" => "Delete a quote by ID",
        "GET /api/authors/" => "Retrieve all authors",
        "POST /api/authors/" => "Create a new author",
        "PUT /api/authors/" => "Update an author",
        "DELETE /api/authors/" => "Delete an author",
        "GET /api/categories/" => "Retrieve all categories",
        "POST /api/categories/" => "Create a new category",
        "PUT /api/categories/" => "Update a category",
        "DELETE /api/categories/" => "Delete a category"
    ]
], JSON_PRETTY_PRINT);
?>
