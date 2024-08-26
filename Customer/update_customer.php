<?php 
require "../Database/db.php";

// Connect to the database
$conn = $connection;

if (isset($_POST["update_customer"])) {
    // Validate the input fields
    if (empty($_POST["customer_name"])) {
        die("Please enter customer name");
    }

    if (empty($_POST["telephone"])) {
        die("Please enter telephone number");
    }

    // Prepare and execute the SQL statement
    $sql = "UPDATE customers SET customer_name = ?, telephone = ? WHERE Customer_ID = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL prepare error: " . $conn->error);
    }

    $stmt->bind_param("sss", $_POST["customer_name"], $_POST["telephone"], $_POST["customer_id"]);

    if ($stmt->execute()) {
        // Redirect to the customers list page after successful update
        header("Location: ../Customer/Customer.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>
