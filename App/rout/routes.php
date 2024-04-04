<?php

$requestedResource =$_SERVER['REQUEST_URI'];

// Check if the requested resource exists
if (!file_exists($requestedResource)) {
    // Set the HTTP response code to 404
    http_response_code(404);

    // Define the path to your 404 page using a file system path
    $notFoundPage = __DIR__ . '/../../public/views/404.php';

    // Include the 404 page
    require_once $notFoundPage;

    // Exit the script
    exit;
}
