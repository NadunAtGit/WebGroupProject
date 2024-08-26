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
    $quantity = $item['quantity'];
    $selling_price = $item['selling_price'];
    $discount = $item['discount'];
    $total_price = $item['total_price'];

    $items[] = $item; // Collect item details
    $total += $total_price; // Calculate the total bill

    // Update quantity in the products table
    $productQuery = "UPDATE products SET quantity = quantity - ? WHERE Product_ID = ?";
    $productStmt = mysqli_prepare($connection, $productQuery);
    mysqli_stmt_bind_param($productStmt, "is", $quantity, $product_id);
    mysqli_stmt_execute($productStmt);

    // Update quantity in the inventory table
    $inventoryQuery = "UPDATE inventory SET quantity = quantity - ? WHERE product_id = ? AND stock_id = ?";
    $inventoryStmt = mysqli_prepare($connection, $inventoryQuery);

    if ($inventoryStmt) {
        mysqli_stmt_bind_param($inventoryStmt, "iss", $quantity, $product_id, $stock_id);
        mysqli_stmt_execute($inventoryStmt);

        // Check if the update was successful
        if (mysqli_stmt_affected_rows($inventoryStmt) === 0) {
            // No rows were affected, likely due to incorrect product_id or stock_id
            echo "No inventory record was updated for Product ID: $product_id and Stock ID: $stock_id";
        }
    } else {
        // Log the error if the query failed
        echo "Failed to prepare inventory update query: " . mysqli_error($connection);
    }
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
