<?php 
require "../Database/db.php";

// Connect to the database
$conn = $connection;

function validateTelephone($telephone) {
    // Define the pattern for Sri Lankan phone numbers
    $pattern = '/^(011|021|023|024|025|026|027|031|032|033|034|035|036|037|038|041|045|047|051|052|054|055|057|063|065|066|067|071|072|075|076|077|078|091|070)\d{7}$/';

    // Check if the telephone number matches the pattern
    return preg_match($pattern, $telephone);
}

function validateEmail($email) {
    // Basic email validation
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if (isset($_POST["add_suppliers"])) {
    // Validate the input fields
    if (empty($_POST["supplier_name"])) {
        die("Please enter supplier name");
    }

    $telephone = $_POST["telephone"];
    $email = $_POST["email"];

    if (!validateTelephone($telephone)) {
        die("Please enter a valid phone number");
    }

    if (!validateEmail($email)) {
        die("Please enter a valid email address");
    }

    if (isset($_POST['items']) && is_array($_POST['items'])) {
        // Get the selected items from the form
        $selectedItems = $_POST['items'];

        // Create a comma-separated string from the selected items
        $selectedItemsString = implode(',', $selectedItems);
    } else {
        $selectedItemsString = '';
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO suppliers (supplier_name, telephone, email, items) VALUES (?, ?, ?, ?)";
    $stmt = $conn->stmt_init();
    
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("ssss", $_POST["supplier_name"], $_POST["telephone"], $_POST["email"], $selectedItemsString);
    
    if ($stmt->execute()) {
        header("Location:../Suppliers/Suppliers.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>
