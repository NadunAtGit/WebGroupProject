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
        $_SESSION['error_message'] = "Please enter username";
        header("Location: Login.php");
        exit;
    }

    if (empty($password)) {
        $_SESSION['error_message'] = "Please enter password";
        header("Location: Login.php");
        exit;
    }

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->stmt_init();

    if (!$stmt->prepare($sql)) {
        $_SESSION['error_message'] = "SQL error: " . $conn->error;
        header("Location: Login.php");
        exit;
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
            $_SESSION['error_message'] = "Invalid password";
            header("Location: Login.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "User not found";
        header("Location: Login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Login.css">
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

    <!-- Error Modal -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="modal show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Error</h5>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $_SESSION['error_message']; ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="location.href='Login.php'">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
