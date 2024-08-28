<?php
include("../Database/db.php");

if (isset($_POST['customer_name'])) {
    $customer_name = mysqli_real_escape_string($connection, $_POST['customer_name']);

    $query = "SELECT Customer_ID FROM customers WHERE customer_name = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $customer_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $customer_id);
    mysqli_stmt_fetch($stmt);

    echo $customer_id ? $customer_id : "Customer not found";
    mysqli_stmt_close($stmt);
}

?>  
