<?php
include("../Database/db.php"); // Ensure this file includes the correct database connection

// Check if 'stock_id' and 'product_id' parameters are set in the URL
if (isset($_GET['stock_id']) && isset($_GET['product_id'])) {
    $stockId = mysqli_real_escape_string($connection, $_GET['stock_id']);
    $productId = mysqli_real_escape_string($connection, $_GET['product_id']);
    
    // Delete the specific inventory item from the database
    $query = "DELETE FROM inventory WHERE stock_id = '$stockId' AND product_id = '$productId'";
    
    if (mysqli_query($connection, $query)) {
        // Redirect to the inventory page with a success message
        header("Location: inventory.php?message=Inventory item deleted successfully");
        exit();
    } else {
        // Handle error
        die("Error deleting inventory item: " . mysqli_error($connection));
    }
} else {
    // Handle the case where 'stock_id' or 'product_id' parameters are missing
    die("Stock ID or Product ID not specified.");
}
?>
