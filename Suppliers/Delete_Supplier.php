<?php
include("../Database/db.php");

// Connect to the database
$conn = $connection;

if (isset($_GET['id'])) {
    $supplier_id = $_GET['id'];

    // Prepare and execute the SQL statement
    $sql = "DELETE FROM suppliers WHERE Supplier_ID = ?";
    $stmt = $conn->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("s", $supplier_id);

    if ($stmt->execute()) {
        header("Location: Suppliers.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
} else {
    die("No supplier ID specified.");
}
?>
