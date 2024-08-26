<?php 
include("../Database/db.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Customers/Customers.css">
    <title>Customers</title>
</head>
<body>
    <div class="container mt-3">
        <div class="box-1 mb-3">
            <h1>ALL CUSTOMERS</h1>
        </div>

        <div class="row mb-3">
            <!-- Search bar -->
            <div class="col-12 col-md-6 mb-2 mb-md-0">
            <form class="d-flex" role="search" id="searchForm" method="GET" action="../Customer/Search_Customer.php">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="searchInput" name="search">
                    <button class="btn btn-outline-success ms-2" type="submit">Search</button>
                    </form>

            </div>
            <!-- Add Customer button -->
            <div class="col-12 col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD CUSTOMER</button>
            </div>
        </div>

        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Telephone</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "SELECT * FROM customers";
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    die("Query failed: " . mysqli_error($connection));
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["Customer_ID"]); ?></td>
                            <td><?php echo htmlspecialchars($row["customer_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["telephone"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Date"]); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-<?php echo $row['Customer_ID']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-<?php echo $row['Customer_ID']; ?>">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $row['Customer_ID']; ?>">Update</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="../Customer/delete_customer.php?id=<?php echo $row['Customer_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Update Modal for each customer -->
                        <div class="modal fade" id="updateModal-<?php echo $row['Customer_ID']; ?>" tabindex="-1" aria-labelledby="updateModalLabel-<?php echo $row['Customer_ID']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel-<?php echo $row['Customer_ID']; ?>">Update Customer: <?php echo htmlspecialchars($row["customer_name"]); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="post" action="../Customer/update_Customer.php">
    <input type="hidden" name="customer_id" value="<?php echo $row['Customer_ID']; ?>">
    <div class="mb-3">
        <label for="update_customer_name-<?php echo $row['Customer_ID']; ?>" class="form-label">Customer Name</label>
        <input type="text" class="form-control" id="update_customer_name-<?php echo $row['Customer_ID']; ?>" name="customer_name" value="<?php echo htmlspecialchars($row["customer_name"]); ?>" required>
    </div>
    <div class="mb-3">
        <label for="update_telephone-<?php echo $row['Customer_ID']; ?>" class="form-label">Telephone</label>
        <input type="text" class="form-control" id="update_telephone-<?php echo $row['Customer_ID']; ?>" name="telephone" value="<?php echo htmlspecialchars($row["telephone"]); ?>">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="update_customer">Update</button>
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

    <!-- Add Customer Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insert_customer.php" method="post">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="Enter customer name" required>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Telephone</label>
                            <input type="text" id="telephone" name="telephone" class="form-control" placeholder="Enter telephone number" required>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" name="add_customer" class="btn btn-primary">Add Customer</button>
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
</body>
</html>

<?php 
require "../Database/db.php";

if(isset($_POST["add_customer"])){
    // Validate the input fields
    if(empty($_POST["customer_name"])){
        die("Please enter a customer name");
    }

    if(empty($_POST["telephone"])){
        die("Please enter a telephone number");
    }

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

    // Get the current date
    $current_date = date('Y-m-d');

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO customers (Customer_ID, customer_name, telephone, Date) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssss", $new_id, $_POST["customer_name"], $_POST["telephone"], $current_date);

    if ($stmt->execute()) {
        echo "<script>alert('Customer added successfully!'); window.location.href = '../Customers/Customers.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

if(isset($_POST["update_customer"])) {
    $customer_id = $_POST["customer_id"];
    $customer_name = $_POST["customer_name"];
    $telephone = $_POST["telephone"];
    $date = $_POST["date"];

    // Update customer details
    $sql = "UPDATE customers SET customer_name = ?, telephone = ?, Date = ? WHERE Customer_ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssss", $customer_name, $telephone, $date, $customer_id);

    if ($stmt->execute()) {
        echo "<script>alert('Customer updated successfully!'); window.location.href = '../Customers/Customers.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
