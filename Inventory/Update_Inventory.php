<?php 
require "../Database/db.php";

// Connect to the database
$conn = $connection;

if (isset($_POST["update_inventory"])) {
    // Validate the input fields
    if (empty($_POST["stock_id"])) {
        die("Stock ID is required");
    }

    if (empty($_POST["product_id"])) {
        die("Product ID is required");
    }

    if (empty($_POST["quantity"]) || !is_numeric($_POST["quantity"]) || $_POST["quantity"] < 0) {
        die("Quantity must be a non-negative number");
    }

    if (empty($_POST["selling_price"]) || !is_numeric($_POST["selling_price"]) || $_POST["selling_price"] < 0) {
        die("Selling price must be a non-negative number");
    }

    // Prepare and execute the SQL statement
    $sql = "UPDATE inventory SET quantity = ?, selling_price = ? WHERE stock_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL prepare error: " . $conn->error);
    }

    $quantity = $_POST["quantity"];
    $selling_price = $_POST["selling_price"];
    $stock_id = $_POST["stock_id"];
    $product_id = $_POST["product_id"];

    $stmt->bind_param("dsss", $quantity, $selling_price, $stock_id, $product_id);

    if ($stmt->execute()) {
        // Redirect to the inventory page after successful update
        header("Location: Inventory.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>
