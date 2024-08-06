<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Logout</title>
    <script>
        // Redirect to the login page after 5 seconds
        setTimeout(function() {
            window.location.href = "../Login/Login.php"; // Adjust the path if necessary
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
</head>
<body>
    <div class="modal show d-block" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logged Out</h5>
                </div>
                <div class="modal-body">
                    <p>You have been logged out.</p>
                </div>
                <div class="modal-footer">
                    <a href="../Login/Login.php" class="btn btn-primary">Go to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
