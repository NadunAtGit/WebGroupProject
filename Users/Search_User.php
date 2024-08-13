<?php
include("../Database/db.php");

$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($connection, $_GET['search']);
}

$query = "SELECT * FROM users WHERE user_name LIKE '%$search%' OR User_ID LIKE '%$search%'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
?>


