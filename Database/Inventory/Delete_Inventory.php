<?php
// Include database connection
include("../Database/db.php");

// Check if the 'stock_id' and 'product_id' parameters are set
if (isset($_GET['stock_id']) && isset($_GET['product_id'])) {
    $stock_id = htmlspecialchars($_GET['stock_id']);
    $product_id = htmlspecialchars($_GET['product_id']);

    // Fetch the quantity of the inventory item being deleted
    $fetchQuantityQuery = "SELECT quantity FROM purchases WHERE Stock_ID = ? AND Product_ID = ?";
    if ($stmt = $connection->prepare($fetchQuantityQuery)) {
        $stmt->bind_param("ss", $stock_id, $product_id);
        $stmt->execute();
        $stmt->bind_result($quantity);
        $stmt->fetch();
        $stmt->close();

        // Update the products table to decrease the quantity
        $updateQuery = "UPDATE products SET quantity = quantity - ? WHERE Product_ID = ?";
        if ($stmt = $connection->prepare($updateQuery)) {
            $stmt->bind_param("is", $quantity, $product_id);
            if ($stmt->execute()) {
                // Now that the quantity is adjusted, you may proceed with any additional actions if needed
                header("Location: ../Inventory/Inventory.php"); // Redirect to inventory list
                exit();
            } else {
                die("Update failed: " . $stmt->error);
            }
        } else {
            die("SQL prepare failed: " . $connection->error);
        }
    } else {
        die("SQL prepare failed: " . $connection->error);
    }
} else {
    die("Invalid request");
}
?>
