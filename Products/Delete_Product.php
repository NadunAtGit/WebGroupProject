<?php 
include("../Database/db.php"); 

if (isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($connection, $_GET['product_id']);

    $query = "DELETE FROM products WHERE Product_ID = '$product_id'";
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
