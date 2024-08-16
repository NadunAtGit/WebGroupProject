<?php 
include("../Database/db.php");

$query = "SELECT Stock_ID FROM purchases ORDER BY Stock_ID DESC LIMIT 1";
$result = mysqli_query($connection, $query);

if ($row = mysqli_fetch_assoc($result)) {
    // Extract the numeric part of the Stock_ID and increment it
    $lastStockId = $row['Stock_ID'];
    $number = intval(substr($lastStockId, 2)) + 1;
    $newStockId = "S-" . str_pad($number, 4, "0", STR_PAD_LEFT);
    echo $newStockId;
} else {
    echo "S-0001"; // Default to S-0001 if no previous orders exist
}
?>
