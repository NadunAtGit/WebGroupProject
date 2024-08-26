<?php 
include("../Database/db.php"); 

$search = isset($_GET['search']) ? $_GET['search'] : '';
$search = '%' . $search . '%'; // For partial matching

// Prepare SQL query with LIKE operator for partial matches
$sql = "SELECT * FROM customers WHERE customer_name LIKE ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Customers/Customers.css">
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
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Telephone</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
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
                } else {
                    echo "<tr><td colspan='5'>No results found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="../SideBar/script.js"></script>
</body>
</html>

<?php 
$stmt->close();
$connection->close();
?>
