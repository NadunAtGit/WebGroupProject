<?php
include("../Database/db.php");

$stock_id = $_GET['stock_id'];

$query = "SELECT selling_price FROM purchases WHERE Stock_ID = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $stock_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo $row['selling_price'];
} else {
    echo "0.00"; // Fallback if no price is found
}
?>
