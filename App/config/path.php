<?php
require_once __DIR__ . '/../bootstrap.php';
const DIRECTORY = '../../public/include/';
function path($path, $data = [])
{
    extract($data);
    $file = __DIR__ . '/' . DIRECTORY . $path . '.php';

    if (file_exists($file)) {
        return require_once $file;
    } else {
        echo "Error: File '$file' does not exist.";
        
        return false;
    }
}
