<?php
require_once __DIR__ . '/../bootstrap.php';
function path($path, $data = [])
{
    extract($data);
    $file = __DIR__ . '/' . PATH . $path . '.php';

    if (file_exists($file)) {
        return require_once $file;
    } else {
        // Handle the error (e.g., log it, return false)
        echo "Error: File '$file' does not exist.";
        return false;
    }
}