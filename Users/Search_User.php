<?php
include("../Database/db.php");

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($connection, $_GET['search']);
    $query = "SELECT * FROM users WHERE user_name LIKE '%$search%' OR first_name LIKE '%$search%' OR email LIKE '%$search%'";
    $result = mysqli_query($connection, $query);
    
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }
} else {
    // Redirect back if no search query is provided
    header("Location: ../Users/Users.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Users/Users.css">
    <title>Search Results</title>
</head>
<body>
    <div class="container mt-3">
        <div class="box-1 mb-3">
            <h1>Search Results</h1>
        </div>

        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["User_ID"]); ?></td>
                            <td><?php echo htmlspecialchars($row["user_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["first_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td><?php echo htmlspecialchars($row["role"]); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-<?php echo $row['User_ID']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-<?php echo $row['User_ID']; ?>">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $row['User_ID']; ?>">Update</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="../Users/Delete_User.php?id=<?php echo $row['User_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Update Modal for each user -->
                        <div class="modal fade" id="updateModal-<?php echo $row['User_ID']; ?>" tabindex="-1" aria-labelledby="updateModalLabel-<?php echo $row['User_ID']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel-<?php echo $row['User_ID']; ?>">Update User: <?php echo htmlspecialchars($row["user_name"]); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="../Users/Update_Users.php">
                                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['User_ID']); ?>">
                                            <div class="mb-3">
                                                <label for="update_user_name-<?php echo $row['User_ID']; ?>" class="form-label">User Name</label>
                                                <input type="text" class="form-control" id="update_user_name-<?php echo $row['User_ID']; ?>" name="user_name" value="<?php echo htmlspecialchars($row["user_name"]); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_first_name-<?php echo $row['User_ID']; ?>" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="update_first_name-<?php echo $row['User_ID']; ?>" name="first_name" value="<?php echo htmlspecialchars($row["first_name"]); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_email-<?php echo $row['User_ID']; ?>" class="form-label">E-mail</label>
                                                <input type="email" class="form-control" id="update_email-<?php echo $row['User_ID']; ?>" name="email" value="<?php echo htmlspecialchars($row["email"]); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_password-<?php echo $row['User_ID']; ?>" class="form-label">New Password (optional)</label>
                                                <input type="password" class="form-control" id="update_password-<?php echo $row['User_ID']; ?>" name="password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_confirm_password-<?php echo $row['User_ID']; ?>" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="update_confirm_password-<?php echo $row['User_ID']; ?>" name="confirm_password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_role-<?php echo $row['User_ID']; ?>" class="form-label">Role</label>
                                                <select class="form-select" id="update_role-<?php echo $row['User_ID']; ?>" name="role" required>
                                                    <option value="" disabled>Select role</option>
                                                    <option value="admin" <?php echo $row["role"] === "admin" ? "selected" : ""; ?>>Admin</option>
                                                    <option value="user" <?php echo $row["role"] === "user" ? "selected" : ""; ?>>User</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" name="update_user">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No results found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="../Users/Users.php" class="btn btn-secondary">Back to Users</a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
