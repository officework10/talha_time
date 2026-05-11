<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * This is a custom index.php for cPanel hosting where document root
 * points to the project root instead of the public folder.
 * 
 * This file should only be used as a fallback. The .htaccess should
 * route most requests directly to public/index.php
 */

// Check if this is a request that should go to the public folder
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// If requesting a file that exists in public folder, serve it directly
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

// Otherwise, let public/index.php handle it
require_once __DIR__.'/public/index.php';
