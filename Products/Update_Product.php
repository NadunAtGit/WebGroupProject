<?php 
include("../Database/db.php"); 

if (isset($_POST['product_id'])) {
    $product_id = mysqli_real_escape_string($connection, $_POST['product_id']);
    $product_name = mysqli_real_escape_string($connection, $_POST['product_name']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);

    $query = "UPDATE products SET 
              product_name = '$product_name',
              quantity = '$quantity',
              category = '$category'
              WHERE Product_ID = '$product_id'";

    $result = mysqli_query($connection, $query);

    if ($result) {
        header("Location: ../Products/Products.php"); // Redirect back to the products page
        exit();
    } else {
        die("Query failed: " . mysqli_error($connection));
    }
} else {
    echo "No product ID specified.";
}
?>
