<?php
// Include database connection
include("../Database/db.php");

// Check if the 'id' parameter is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize and convert to integer

    // Prepare and execute the DELETE query
    $query = "DELETE FROM suppliers WHERE Supplier_ID = ?";
    $stmt = $connection->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Redirect to the suppliers list page after successful deletion
            header("Location: Suppliers.php"); // Update this to your actual page
            exit();
        } else {
            die("Deletion failed: " . $stmt->error);
        }
    } else {
        die("SQL prepare failed: " . $connection->error);
    }
} else {
    die("Invalid request");
}
?>
