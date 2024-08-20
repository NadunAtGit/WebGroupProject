<?php
include("../Database/db.php");

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=inventory.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('Stock ID', 'Product ID', 'Product Name', 'Category', 'Quantity', 'Selling Price'));

$query = "
    SELECT 
        p.Stock_ID, 
        p.Product_ID, 
        pr.product_name, 
        pr.category, 
        p.quantity, 
        p.selling_price
    FROM purchases p
    JOIN products pr ON p.Product_ID = pr.Product_ID
";
$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

fclose($output);
?>
