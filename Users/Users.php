<?php 
include("../Database/db.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Users/Users.css">
    <title>Users</title>
</head>
<body>
    <div class="container mt-3">
        <div class="box-1 mb-3">
           
            <h1>ALL USERS</h1>
        </div>

        <div class="row mb-3">
            <!-- Search bar -->
            <div class="col-12 col-md-6 mb-2 mb-md-0">
                <form class="d-flex" role="search" id="searchForm" method="GET" action="../Users/Search_User.php">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="searchInput" name="search">
                    <button class="btn btn-outline-success ms-2" type="submit">Search</button>
                </form>
            </div>
            <!-- Add User button Here have -->
            <div class="col-12 col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD USER</button>
            </div>
        </div>


        

        <table class="table table-hover table-bordered table-striped" id="xx">
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
                $query = "SELECT * FROM users";
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    die("Query failed: " . mysqli_error($connection));
                } else {
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
                                    <button class="btn btn-secondary dropdown-toggle dynamic-btn" type="button" id="dropdownMenuButton-<?php echo $row['User_ID']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
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
                                        <form method="post" action="../Users/Update_Users.php" id="updateUserForm-<?php echo $row['User_ID']; ?>">
                                            <input type="hidden" name="user_id" value="<?php echo $row['User_ID']; ?>">
                                            <div class="mb-3">
                                                <label for="update_name-<?php echo $row['User_ID']; ?>" class="form-label">User Name</label>
                                                <input type="text" class="form-control" id="update_user_name-<?php echo $row['User_ID']; ?>" name="user_name" value="<?php echo htmlspecialchars($row["user_name"]); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_name-<?php echo $row['User_ID']; ?>" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="update_name-<?php echo $row['User_ID']; ?>" name="first_name" value="<?php echo htmlspecialchars($row["first_name"]); ?>" required>
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
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add User Modal -->
    <!-- Add User Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="post" action="../Users/Insert_Users.php" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="user_name" class="form-label">User Name</label>
        <input type="text" class="form-control" id="user_name" name="user_name" required>
    </div>
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
            <option value="" disabled selected>Select role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="profile_image" class="form-label">Profile Image</label>
        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="add_users">Add</button>
    </div>
</form>

            </div>
        </div>
    </div>
</div>


    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="../SideBar/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function (button) {
        button.addEventListener('click', function (event) {
            var userId = button.getAttribute('data-bs-id');
            var userName = button.getAttribute('data-bs-name');
            var userFirstName = button.getAttribute('data-bs-first-name');
            var userEmail = button.getAttribute('data-bs-email');
            var userRole = button.getAttribute('data-bs-role');

            var updateModal = document.getElementById(`updateModal-${userId}`);
            var modalTitle = updateModal.querySelector('.modal-title');
            var userNameInput = updateModal.querySelector(`#update_user_name-${userId}`);
            var firstNameInput = updateModal.querySelector(`#update_first_name-${userId}`);
            var emailInput = updateModal.querySelector(`#update_email-${userId}`);
            var roleInput = updateModal.querySelector(`#update_role-${userId}`);
            var userIdInput = updateModal.querySelector('input[name="user_id"]');

            modalTitle.textContent = `Update User: ${userName}`;
            userNameInput.value = userName;
            firstNameInput.value = userFirstName;
            emailInput.value = userEmail;
            roleInput.value = userRole;
            userIdInput.value = userId;
        });
    });
});
    </script>

</body>
</html>


