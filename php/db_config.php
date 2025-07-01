<?php
// php/db_config.php

define('DB_SERVER', 'localhost'); // Your database host (e.g., 'localhost' or '127.0.0.1')
define('DB_USERNAME', 'root');    // Your MySQL username
define('DB_PASSWORD', '');        // Your MySQL password
define('DB_NAME', 'seacatering_db'); // The name of your database

// Attempt to connect to MySQL database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>