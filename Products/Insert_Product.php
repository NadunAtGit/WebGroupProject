<?php 
include("../Database/db.php"); 

if (isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($connection, $_POST['product_name']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);

    $query = "INSERT INTO products (product_name, quantity, category) VALUES ('$product_name', '$quantity', '$category')";
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
