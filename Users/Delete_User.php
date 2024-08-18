<?php
include("../Database/db.php"); // Make sure this includes the correct database connection

// Check if 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $userId = mysqli_real_escape_string($connection, $_GET['id']);
    
    // Delete the specific user from the database
    $query = "DELETE FROM users WHERE User_ID = '$userId'";
    
    if (mysqli_query($connection, $query)) {
        // Redirect to the users page with a success message
        header("Location: ../Users/users.php?message=User deleted successfully");
        exit();
    } else {
        // Handle error
        die("Error deleting user: " . mysqli_error($connection));
    }
} else {
    // Handle the case where 'id' parameter is missing
    die("User ID not specified.");
}
?>
