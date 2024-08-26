<?php 
require "../Database/db.php";

// if(isset($_POST["add_customer"])){
//     // Validate the input fields
//     if(empty($_POST["customer_name"])){
//         die("Please enter a customer name");
//     }

//     if(empty($_POST["telephone"])){
//         die("Please enter a telephone number");
//     }

//     // if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
//     //     die("Please enter a valid email address");
//     // }

//     if(empty($_POST["date"])){
//         die("Please select a purchase date");
//     }

//     // Additional date validation can be added if needed
//     $purchase_date = DateTime::createFromFormat('Y-m-d', $_POST["date"]);
//     if (!$purchase_date) {
//         die("Please enter a valid date in YYYY-MM-DD format");
//     }

//     // Generate the customized Customer_ID
//     $sql = "SELECT Customer_ID FROM customers ORDER BY Customer_ID DESC LIMIT 1";
//     $result = $connection->query($sql);

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         $last_id = $row['Customer_ID'];
//         $last_numeric_id = intval(substr($last_id, 2)); // Get the numeric part of the last Customer_ID
//         $new_id = 'C-' . str_pad($last_numeric_id + 1, 3, '0', STR_PAD_LEFT);
//     } else {
//         // If there are no customers in the table, start with C-001
//         $new_id = 'C-001';
//     }

//     // Get the current date
//     $current_date = date('Y-m-d');

//     // Prepare and execute the SQL statement
//     $sql = "INSERT INTO customers (Customer_ID, customer_name, telephone, Date) VALUES (?, ?, ?, ?)";
//     $stmt = $connection->stmt_init();
    
//     if(!$stmt->prepare($sql)){
//         die("SQL error: " . $connection->error);
//     }

//     $stmt->bind_param("ssss", $new_id, $_POST["customer_name"], $_POST["telephone"], $current_date);
    
//     if($stmt->execute()){
//         // Redirect to the customers list page or another appropriate page
//         header("Location: ../Customers/customers.php");
//         exit;
//     } else {
//         die("Execution error: " . $stmt->error);
//     }
// }
// ?


if(isset($_POST["add_customer"])){
    // Validate the input fields
    if(empty($_POST["customer_name"])){
        die("Please enter a customer name");
    }

    if(empty($_POST["telephone"])){
        die("Please enter a telephone number");
    }

    if(empty($_POST["date"])){
        die("Please select a purchase date");
    }

    // Validate the selected date format
    $purchase_date = DateTime::createFromFormat('Y-m-d', $_POST["date"]);
    if (!$purchase_date) {
        die("Please enter a valid date in YYYY-MM-DD format");
    }

    // Convert the DateTime object to a string in the correct format
    $formatted_date = $purchase_date->format('Y-m-d');

    // Generate the customized Customer_ID
    $sql = "SELECT Customer_ID FROM customers ORDER BY Customer_ID DESC LIMIT 1";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['Customer_ID'];
        $last_numeric_id = intval(substr($last_id, 2)); // Get the numeric part of the last Customer_ID
        $new_id = 'C-' . str_pad($last_numeric_id + 1, 3, '0', STR_PAD_LEFT);
    } else {
        // If there are no customers in the table, start with C-001
        $new_id = 'C-001';
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO customers (Customer_ID, customer_name, telephone, Date) VALUES (?, ?, ?, ?)";
    $stmt = $connection->stmt_init();
    
    if(!$stmt->prepare($sql)){
        die("SQL error: " . $connection->error);
    }

    $stmt->bind_param("ssss", $new_id, $_POST["customer_name"], $_POST["telephone"], $formatted_date);
    
    if($stmt->execute()){
        // Redirect to the customers list page or another appropriate page
        header("Location: ../Customer/customer.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>