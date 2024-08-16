<?php 
require "../Database/db.php";

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
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['User_ID'];
        $last_numeric_id = intval(substr($last_id, 2)); // Get the numeric part of the last User_ID
        $new_id = 'U-' . str_pad($last_numeric_id + 1, 3, '0', STR_PAD_LEFT);
    } else {
        // If there are no users in the table, start with U-001
        $new_id = 'U-001';
    }

    // Handle the image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileType = $_FILES['profile_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Check if the file is an image
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedExtensions)) {
            // Rename the file to the username
            $newFileName = $_POST['user_name'] . '.' . $fileExtension;
            $uploadFileDir = '../User_Images/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $image_path = $dest_path;
            } else {
                die("Error moving the file");
            }
        } else {
            die("Only image files are allowed");
        }
    } else {
        // If no file uploaded, set default or handle accordingly
        $image_path = null;
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO users (User_ID, user_name, first_name, email, password_hash, role, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->stmt_init();
    
    if(!$stmt->prepare($sql)){
        die("SQL error: " . $connection->error);
    }

    $stmt->bind_param("sssssss", $new_id, $_POST["user_name"], $_POST["first_name"], $_POST["email"], $password_hash, $role, $image_path);
    
    if($stmt->execute()){
        // Redirect to the users list page or another appropriate page
        header("Location: ../Users/Users.php");
        exit;
    } else {
        die("Execution error: " . $stmt->error);
    }
}
?>