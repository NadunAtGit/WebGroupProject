<?php
session_start();
require '../Database/db.php'; // Adjust the path if necessary

// Connect to the database
$conn = $connection; // Use the returned connection from db.php

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate input fields
    if (empty($username)) {
        die("Please enter username");
    }

    if (empty($password)) {
        die("Please enter password");
    }

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $conn->error);
    }

    // Bind the username parameter
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();

    // Check if a user with the given username exists
    if ($row = $result->fetch_assoc()) {
        // Verify the password
        if (password_verify($password, $row["password_hash"])) {
            // Password is correct
            $_SESSION["user_id"] = $row["User_ID"];
            $_SESSION["user_name"] = $row["user_name"];
            $_SESSION["user_role"] = $row["role"];
            $_SESSION['user_image'] = $row["image_path"];
            
            header("Location: ../SideBar/SideBar.php");
            exit;
        } else {
            die("Invalid password");
        }
    } else {
        die("User not found");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login</title>
</head>
<body>
    <div class="mask">
        <img src="c1.jpg" alt="background-image" class="bg-img">
        <div class="header d-flex align-items-center mb-4">
            <i class='bx bx-laptop bx-lg '></i>
            <h1 id="company_name" class="ms-3">Tech-Tool</h1>
        </div>
        <div class="content">
            <div class="form-class p-4 rounded shadow">
                <form action="Login.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
