<?php 
include("../Database/db.php"); 

if (isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($connection, $_POST['product_name']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    
    // Get the last Product_ID
    $query = "SELECT Product_ID FROM products ORDER BY Product_ID DESC LIMIT 1";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $lastProductID = $row['Product_ID'];

    // Extract the numeric part and increment it
    $numericPart = intval(substr($lastProductID, 2));
    $newID = 'P-' . str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);

    // Insert the new product with the custom Product_ID
    $query = "INSERT INTO products (Product_ID, product_name, quantity, category) VALUES ('$newID', '$product_name', '$quantity', '$category')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        header("Location: ../Products/Products.php"); // Redirect to the products page
        exit();
    } else {
        die("Query failed: " . mysqli_error($connection));
    }
} else {
    echo "No data submitted.";
}
?>
