<?php 
include("../Database/db.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_purchase'])) {
    $stock_id = $_POST['stock_id']; 
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $selling_price = $_POST['selling_price']; // Selling price is used instead of price_per_unit
    $supplier_id = $_POST['supplier_id'];
    $date = $_POST['date'];
    $category = ''; // Initialize category

    // Check if the product ID exists in the products table
    $product_check_query = "SELECT * FROM products WHERE Product_ID = '$product_id'";
    $product_check_result = mysqli_query($connection, $product_check_query);

    if (mysqli_num_rows($product_check_result) > 0) {
        // Fetch product details
        $product_row = mysqli_fetch_assoc($product_check_result);
        $new_quantity = $product_row['quantity'] + $quantity;
        $category = $product_row['category']; // Get the category

        // Update product quantity in the products table
        $update_product_query = "UPDATE products SET quantity = $new_quantity WHERE Product_ID = '$product_id'";
        mysqli_query($connection, $update_product_query);

        // Insert the purchase into the purchases table
        $insert_purchase_query = "INSERT INTO purchases (Stock_ID, Product_ID, quantity, price_per_unit, Supplier_ID, Date, selling_price) 
                                  VALUES ('$stock_id', '$product_id', $quantity, $selling_price, '$supplier_id', '$date', $selling_price)";
        mysqli_query($connection, $insert_purchase_query);

        // Insert the data into the inventory table
        $insert_inventory_query = "INSERT INTO inventory (stock_id, product_id, quantity, selling_price, category) 
                                   VALUES ('$stock_id', '$product_id', $quantity, $selling_price, '$category')";
        mysqli_query($connection, $insert_inventory_query);

        // Redirect to the Purchases page
        header("Location: ../Purchases/Purchases.php");
        exit();
    } else {
        // Redirect to the page with a product ID warning
        header("Location: Purchases.php?error=invalid_product_id");
        exit();
    }
}
?>
