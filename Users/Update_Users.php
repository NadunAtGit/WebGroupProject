<?php 
require "../Database/db.php";

// Connect to the database
$conn = $connection;

if (isset($_POST["update_user"])) {
    // Validate the input fields
    if (empty($_POST["user_name"])) {
        die("Please enter user name");
    }

    if (empty($_POST["first_name"])) {
        die("Please enter first name");
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email address");
    }

    // Check if password needs to be updated
    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        if (strlen($_POST["password"]) < 8) {
            die("Password must be longer than 8 characters");
        }

        if (!preg_match("/[a-z]/i", $_POST["password"])) {
            die("Password must have at least one letter");
        }

        if (!preg_match("/[0-9]/", $_POST["password"])) {
            die("Password must have at least one number");
        }

        if ($_POST["password"] !== $_POST["confirm_password"]) {
            die("Passwords do not match");
        }

        // Hash the password
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // Prepare and execute the SQL statement with password update
        $sql = "UPDATE users SET user_name = ?, first_name = ?, email = ?, password_hash = ?, role = ? WHERE User_ID = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("SQL prepare error: " . $conn->error);
        }

        $stmt->bind_param("ssssss", $_POST["user_name"], $_POST["first_name"], $_POST["email"], $password_hash, $_POST["role"], $_POST["user_id"]);
    } else {
        // Prepare and execute the SQL statement without password update
        $sql = "UPDATE users SET user_name = ?, first_name = ?, email = ?, role = ? WHERE User_ID = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("SQL prepare error: " . $conn->error);
        }

        $stmt->bind_param("sssss", $_POST["user_name"], $_POST["first_name"], $_POST["email"], $_POST["role"], $_POST["user_id"]);
    }

    if ($stmt->execute()) {
        // Redirect to the users list page after successful update
        header("Location: ../Users/Users.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>
