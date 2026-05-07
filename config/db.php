<?php
// ----------------------------------------------------------------
// Database configuration
// Adjust DB_HOST / DB_USER / DB_PASS to match your environment.
// ----------------------------------------------------------------
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'socialnet');
define('DB_USER', 'root');        // change to a dedicated MySQL user if needed
define('DB_PASS', '');            // change to the correct password

/**
 * Returns a MySQLi connection.  Terminates with an HTTP 500 on failure.
 */
function get_db(): mysqli
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);
    if ($conn->connect_error) {
        http_response_code(500);
        die('<h2>Database connection failed: ' . htmlspecialchars($conn->connect_error) . '</h2>');
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}
