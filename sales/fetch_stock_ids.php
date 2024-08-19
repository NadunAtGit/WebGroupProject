<?php
include("../Database/db.php");

$product_id = $_GET['product_id'];

$query = "SELECT Stock_ID FROM purchases WHERE Product_ID = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$stockIDs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $stockIDs[] = $row;
}

echo json_encode($stockIDs);
?>
