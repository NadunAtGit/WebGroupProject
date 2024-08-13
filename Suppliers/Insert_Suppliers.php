<?php 




require "../Database/db.php";

// Connect to the database
$conn = $connection;

function validateTelephone($telephone) {
    $pattern = '/^(011|021|023|024|025|026|027|031|032|033|034|035|036|037|038|041|045|047|051|052|054|055|057|063|065|066|067|071|072|075|076|077|078|091|070)\d{7}$/';
    return preg_match($pattern, $telephone);
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function generateSupplierID($conn) {
    // Get the last Supplier_ID from the suppliers table
    $query = "SELECT Supplier_ID FROM suppliers ORDER BY Supplier_ID DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $lastID = mysqli_fetch_assoc($result)['Supplier_ID'];

    // If there are no existing IDs, start with S-001
    if (!$lastID) {
        return 'S-001';
    }

    // Extract the numeric part and increment it
    $numericPart = (int)substr($lastID, 2);  // Skip the "S-" part
    $newID = 'S-' . str_pad($numericPart + 1, 3, '0', STR_PAD_LEFT);

    return $newID;
}

if (isset($_POST["add_suppliers"])) {
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
        $selectedItems = implode(',', $_POST['items']);
    } else {
        $selectedItems = '';
    }

    // Generate the custom Supplier_ID
    $supplierID = generateSupplierID($conn);

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO suppliers (Supplier_ID, supplier_name, telephone, email, items) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->stmt_init();
    
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("sssss", $supplierID, $_POST["supplier_name"], $_POST["telephone"], $_POST["email"], $selectedItems);
    
    if ($stmt->execute()) {
        header("Location:../Suppliers/Suppliers.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>
