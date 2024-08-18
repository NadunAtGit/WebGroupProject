<?php
// Define database connection constants
if (!defined("HOSTNAME")) {
    define("HOSTNAME", "localhost");
}
if (!defined("USERNAME")) {
    define("USERNAME", "root");
}
if (!defined("PASSWORD")) {
    define("PASSWORD", "");
}
if (!defined("DATABASE")) {
    define("DATABASE", "inventory2");
}

try {
    // Attempt to establish a connection to the database
    $connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    // Check if the connection was successful
    if (!$connection) {
        // Throw an exception with a descriptive error message
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Return the connection object
    return $connection;
} catch (Exception $e) {
    // Handle the exception and display the error message
    echo "Error: " . $e->getMessage();

    // Log the error message to a file (optional)
    error_log(date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n", 3, "error_log.txt");

    // Exit the script if there is a connection error
    exit;
}
?>
