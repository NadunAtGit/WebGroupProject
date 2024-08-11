<?php 
require "../Database/db.php";

// Connect to the database
$conn = $connection;

if(isset($_POST["add_users"])){
    // Validate the input fields
    if(empty($_POST["user_name"])){
        die("Please enter a user name");
    }

    if(empty($_POST["first_name"])){
        die("Please enter a first name");
    }

    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email address");
    }

    if(strlen($_POST["password"]) < 8){
        die("Password must be at least 8 characters long");
    }

    if(!preg_match("/[a-z]/i", $_POST["password"])){
        die("Password must contain at least one letter");
    }

    if(!preg_match("/[0-9]/", $_POST["password"])){
        die("Password must contain at least one number");
    }

    if($_POST["password"] !== $_POST["confirm_password"]){
        die("Passwords do not match");
    }

    // Determine the role based on the dropdown selection
    $role = $_POST["role"];

    // Hash the password
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Generate the customized User_ID
    $sql = "SELECT User_ID FROM users ORDER BY User_ID DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['User_ID'];
        $last_numeric_id = intval(substr($last_id, 2)); // Get the numeric part of the last User_ID
        $new_id = 'U-' . str_pad($last_numeric_id + 1, 3, '0', STR_PAD_LEFT);
    } else {
        // If there are no users in the table, start with U-001
        $new_id = 'U-001';
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO users (User_ID, user_name, first_name, email, password_hash, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->stmt_init();
    
    if(!$stmt->prepare($sql)){
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $new_id, $_POST["user_name"], $_POST["first_name"], $_POST["email"], $password_hash, $role);
    
    if($stmt->execute()){
        // Redirect to the users list page or another appropriate page
        header("Location: ../Users/Users.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>
