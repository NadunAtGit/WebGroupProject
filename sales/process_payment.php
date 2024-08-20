<?php
include("../Database/db.php");

$data = json_decode(file_get_contents("php://input"), true);

foreach ($data as $item) {
    $product_id = $item['product_id'];
    $stock_id = $item['stock_id'];
    $quantity = $item['quantity'];

    // Update quantity in the products table
    $productQuery = "UPDATE products SET quantity = quantity - ? WHERE Product_ID = ?";
    $productStmt = mysqli_prepare($connection, $productQuery);
    mysqli_stmt_bind_param($productStmt, "is", $quantity, $product_id);
    mysqli_stmt_execute($productStmt);

    // Update quantity in the inventory table
    $inventoryQuery = "UPDATE inventory SET quantity = quantity - ? WHERE product_id = ? AND stock_id = ?";
    $inventoryStmt = mysqli_prepare($connection, $inventoryQuery);
    mysqli_stmt_bind_param($inventoryStmt, "iss", $quantity, $product_id, $stock_id);
    mysqli_stmt_execute($inventoryStmt);
}

echo "Payment processed successfully!";
?>
