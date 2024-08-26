<?php
include("../Database/db.php"); // Ensure this file includes the correct database connection

// Check if 'stock_id' and 'product_id' parameters are set in the URL
if (isset($_GET['stock_id']) && isset($_GET['product_id'])) {
    $stockId = mysqli_real_escape_string($connection, $_GET['stock_id']);
    $productId = mysqli_real_escape_string($connection, $_GET['product_id']);
    
    // Retrieve the quantity from the inventory before deleting
    $quantityQuery = "SELECT quantity FROM inventory WHERE stock_id = '$stockId' AND product_id = '$productId'";
    $quantityResult = mysqli_query($connection, $quantityQuery);

    if ($quantityResult && mysqli_num_rows($quantityResult) > 0) {
        $row = mysqli_fetch_assoc($quantityResult);
        $quantityToRemove = $row['quantity'];

        // Update the product quantity in the products table
        $updateProductQuery = "UPDATE products SET quantity = quantity - $quantityToRemove WHERE Product_ID = '$productId'";
        if (mysqli_query($connection, $updateProductQuery)) {
            
            // Delete the specific inventory item from the database
            $deleteQuery = "DELETE FROM inventory WHERE stock_id = '$stockId' AND product_id = '$productId'";
            if (mysqli_query($connection, $deleteQuery)) {
                // Redirect to the inventory page with a success message
                header("Location: inventory.php?message=Inventory item deleted successfully");
                exit();
            } else {
                // Handle error during deletion
                die("Error deleting inventory item: " . mysqli_error($connection));
            }
        } else {
            // Handle error during product quantity update
            die("Error updating product quantity: " . mysqli_error($connection));
        }
    } else {
        // Handle the case where the inventory item is not found
        die("Inventory item not found.");
    }
} else {
    // Handle the case where 'stock_id' or 'product_id' parameters are missing
    die("Stock ID or Product ID not specified.");
}
?>
