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

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO users (user_name, first_name, email, password_hash, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->stmt_init();
    
    if(!$stmt->prepare($sql)){
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("sssss", $_POST["user_name"], $_POST["first_name"], $_POST["email"], $password_hash, $role);
    
    if($stmt->execute()){
        // Redirect to the users list page or another appropriate page
        header("Location: ../Users/Users.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>
