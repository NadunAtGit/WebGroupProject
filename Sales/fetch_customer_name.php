<?php
include("../Database/db.php");

if (isset($_GET['phone_number'])) {
    $phone_number = mysqli_real_escape_string($connection, $_GET['phone_number']);
    $query = "SELECT customer_name FROM customers WHERE telephone = '$phone_number'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['customer_name'];
    } else {
        echo "No customer found";
    }
} else {
    echo "Phone number not provided";
}
?>
