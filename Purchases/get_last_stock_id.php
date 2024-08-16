<?php 
include("../Database/db.php");

$query = "SELECT Stock_ID FROM purchases ORDER BY Stock_ID DESC LIMIT 1";
$result = mysqli_query($connection, $query);
if ($row = mysqli_fetch_assoc($result)) {
    echo $row['Stock_ID'];
} else {
    echo "S-0001"; // Default to S-0001 if no previous orders exist
}
?>
