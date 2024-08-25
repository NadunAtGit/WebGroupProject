<?php
include("../Database/db.php"); // Ensure this path is correct and includes your database connection

// Check if 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $customerId = mysqli_real_escape_string($connection, $_GET['id']);
    
    // Delete the specific customer from the database
    $query = "DELETE FROM customers WHERE Customer_ID = '$customerId'";
    
    if (mysqli_query($connection, $query)) {
        // Redirect to the customers page with a success message
        header("Location: ../Customer/customer.php?message=Customer deleted successfully");
        exit();
    } else {
        // Handle error
        die("Error deleting customer: " . mysqli_error($connection));
    }
} else {
    // Handle the case where 'id' parameter is missing
    die("Customer ID not specified.");
}
?>
