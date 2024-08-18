<?php
include("../Database/db.php");

// Connect to the database
$conn = $connection;

// Function to validate the telephone number
function validateTelephone($telephone) {
    $pattern = '/^(071|077|076|011|025)\d{7}$/';
    return preg_match($pattern, $telephone);
}

function validateEmail($email) {
    // Basic email validation
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if (isset($_POST["update_supplier"])) {
    $supplier_id = $_POST["supplier_id"];
    $name = $_POST["supplier_name"];
    $telephone = $_POST["telephone"];
    $email = $_POST["email"];
    $items = isset($_POST['items']) ? implode(',', $_POST['items']) : '';

    // Validate input fields
    if (empty($name)) {
        die("Please enter a supplier name.");
    }

    if (!validateTelephone($telephone)) {
        die("Please enter a valid phone number.");
    }

    if (!validateEmail($email)) {
        die("Please enter a valid email address.");
    }

    // Prepare and execute the SQL statement
    $sql = "UPDATE suppliers SET supplier_name = ?, telephone = ?, email = ?, items = ? WHERE Supplier_ID = ?";
    $stmt = $conn->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("sssss", $name, $telephone, $email, $items, $supplier_id);

    if ($stmt->execute()) {
        header("Location: Suppliers.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>
