<?php 
include("../Database/db.php");

$data = json_decode(file_get_contents("php://input"), true);

// Fetch the last Bill_ID and generate the new Bill_ID
$lastBillQuery = "SELECT Bill_ID FROM sales ORDER BY Bill_ID DESC LIMIT 1";
$lastBillResult = mysqli_query($connection, $lastBillQuery);
$lastBillRow = mysqli_fetch_assoc($lastBillResult);

if ($lastBillRow) {
    $lastBillID = $lastBillRow['Bill_ID'];
    $numericPart = intval(substr($lastBillID, 2)); // Extract the numeric part of the Bill_ID
    $newBillID = 'B-' . str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT); // Increment and format as B-0001
} else {
    // If no Bill_ID exists, start with B-0001
    $newBillID = 'B-0001';
}

// Assuming customer_id is sent via POST or can be included in the JSON data
$customer_id = mysqli_real_escape_string($connection, $_POST['customer_id'] ?? $data['customer_id']);

$total = 0;
$items = [];

foreach ($data as $item) {
    $product_id = mysqli_real_escape_string($connection, $item['product_id']);
    $stock_id =  mysqli_real_escape_string($connection, $item['stock_id']);
    $requested_quantity = $item['quantity'];
    $selling_price = $item['selling_price'];
    $discount = $item['discount'];
    $total_price = $item['total_price'];

    // Check available quantity in the products table
    $productQuery = "SELECT quantity FROM products WHERE Product_ID = ?";
    $productStmt = mysqli_prepare($connection, $productQuery);
    mysqli_stmt_bind_param($productStmt, "s", $product_id);
    mysqli_stmt_execute($productStmt);
    mysqli_stmt_bind_result($productStmt, $available_quantity_product);
    mysqli_stmt_fetch($productStmt);
    mysqli_stmt_close($productStmt);

    // Check available quantity in the inventory table for the specific stock_id
    $inventoryQuery = "SELECT quantity FROM inventory WHERE product_id = ? AND stock_id = ?";
    $inventoryStmt = mysqli_prepare($connection, $inventoryQuery);
    mysqli_stmt_bind_param($inventoryStmt, "ss", $product_id, $stock_id);
    mysqli_stmt_execute($inventoryStmt);
    mysqli_stmt_bind_result($inventoryStmt, $available_quantity_inventory);
    mysqli_stmt_fetch($inventoryStmt);
    mysqli_stmt_close($inventoryStmt);

    // Determine the maximum quantity that can be sold (whichever is lower)
    $available_quantity = min($available_quantity_product, $available_quantity_inventory);
    $quantity_to_sell = min($requested_quantity, $available_quantity);

    // Update quantity in the products table
    $productUpdateQuery = "UPDATE products SET quantity = GREATEST(0, quantity - ?) WHERE Product_ID = ?";
    $productUpdateStmt = mysqli_prepare($connection, $productUpdateQuery);
    mysqli_stmt_bind_param($productUpdateStmt, "is", $quantity_to_sell, $product_id);
    mysqli_stmt_execute($productUpdateStmt);
    mysqli_stmt_close($productUpdateStmt);

    // Update quantity in the inventory table
    $inventoryUpdateQuery = "UPDATE inventory SET quantity = GREATEST(0, quantity - ?) WHERE product_id = ? AND stock_id = ?";
    $inventoryUpdateStmt = mysqli_prepare($connection, $inventoryUpdateQuery);
    mysqli_stmt_bind_param($inventoryUpdateStmt, "iss", $quantity_to_sell, $product_id, $stock_id);
    mysqli_stmt_execute($inventoryUpdateStmt);
    mysqli_stmt_close($inventoryUpdateStmt);

    // Calculate the total price for the item with the adjusted quantity
    $item_total_price = $quantity_to_sell * $selling_price * (1 - $discount / 100);

    // Update the items and total amount
    $item['quantity'] = $quantity_to_sell;
    $item['total_price'] = $item_total_price;
    $items[] = $item;
    $total += $item_total_price;
}

// Serialize items array to store as JSON text
$items_serialized = json_encode($items);

// Insert into sales table
$salesQuery = "INSERT INTO sales (Bill_ID, Customer_ID, Total, items, date) VALUES (?, ?, ?, ?, NOW())";
$salesStmt = mysqli_prepare($connection, $salesQuery);
mysqli_stmt_bind_param($salesStmt, "ssds", $newBillID, $customer_id, $total, $items_serialized);
mysqli_stmt_execute($salesStmt);

if (mysqli_stmt_affected_rows($salesStmt) > 0) {
    echo "Payment processed successfully!";
} else {
    echo "Failed to process payment.";
}

mysqli_close($connection);
?>
