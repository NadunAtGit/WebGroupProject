<?php
// Include database connection
include("../Database/db.php");

// Check if the 'id' parameter is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize and convert to integer

    // Prepare and execute the DELETE query
    $query = "DELETE FROM users WHERE User_ID = ?";
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Redirect to the users list page after successful deletion
            header("Location: ../Users/Users.php");
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
