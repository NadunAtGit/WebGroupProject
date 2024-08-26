<?php 
include("../Database/db.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
</head>
<body>
    <div class="container mt-3">
        <h1>Inventory Details</h1>

        <!-- Search bar for filtering by product name -->
        <div class="mb-3">
            <label for="searchInput" class="form-label">Search by Product Name:</label>
            <input type="text" class="form-control" id="searchInput" onkeyup="filterTable()" placeholder="Enter product name">
        </div>

        <!-- Dropdown for filtering by category -->
        <div class="mb-3">
            <label for="categoryDropdown" class="form-label">Filter by Category:</label>
            <select class="form-select" id="categoryDropdown" onchange="filterTable()">
                <option value="All">All</option>
                <option value="Laptop">Laptop</option>
                <option value="Phones">Phones</option>
                <option value="Parts">Parts</option>
            </select>
        </div>

        <!-- Button for exporting data to CSV -->
        <div class="mb-3">
            <a href="export_to_csv.php" class="btn btn-primary">
                <i class="bi bi-file-earmark-csv"></i> Export to CSV
            </a>
        </div>

        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>Stock ID</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Selling Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="inventoryTable">
                <?php 
                $query = "
                    SELECT 
                        i.stock_id, 
                        i.product_id, 
                        p.product_name, 
                        p.category, 
                        i.quantity, 
                        i.selling_price
                    FROM inventory i
                    JOIN products p ON i.product_id = p.product_id
                ";
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    die("Query failed: " . mysqli_error($connection));
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr data-category="<?php echo htmlspecialchars($row["category"]); ?>" data-name="<?php echo htmlspecialchars($row["product_name"]); ?>">
                            <td><?php echo htmlspecialchars($row["stock_id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["product_id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["category"]); ?></td>
                            <td><?php echo htmlspecialchars($row["quantity"]); ?></td>
                            <td><?php echo htmlspecialchars($row["selling_price"]); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-<?php echo $row['stock_id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-<?php echo $row['stock_id']; ?>">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $row['stock_id']; ?>">Update</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="Delete_Inventory.php?stock_id=<?php echo $row['stock_id']; ?>&product_id=<?php echo $row['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Update Modal for each inventory item -->
                        <div class="modal fade" id="updateModal-<?php echo $row['stock_id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel-<?php echo $row['stock_id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel-<?php echo $row['stock_id']; ?>">Update Inventory: <?php echo htmlspecialchars($row["product_name"]); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="Update_Inventory.php">
                                            <input type="hidden" name="stock_id" value="<?php echo $row['stock_id']; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                            <div class="mb-3">
                                                <label for="update_quantity-<?php echo $row['stock_id']; ?>" class="form-label">Quantity</label>
                                                <input type="number" class="form-control" id="update_quantity-<?php echo $row['stock_id']; ?>" name="quantity" value="<?php echo htmlspecialchars($row["quantity"]); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_price-<?php echo $row['stock_id']; ?>" class="form-label">Selling Price</label>
                                                <input type="text" class="form-control" id="update_price-<?php echo $row['stock_id']; ?>" name="selling_price" value="<?php echo htmlspecialchars($row["selling_price"]); ?>" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" name="update_inventory">Update</button>
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

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript to filter table rows by category and search input -->
    <script>
        function filterTable() {
            var searchInput = document.getElementById("searchInput").value.toLowerCase();
            var dropdown = document.getElementById("categoryDropdown");
            var selectedCategory = dropdown.value.toLowerCase();
            var table = document.getElementById("inventoryTable");
            var rows = table.getElementsByTagName("tr");

            for (var i = 0; i < rows.length; i++) {
                var productName = rows[i].getAttribute("data-name").toLowerCase();
                var category = rows[i].getAttribute("data-category").toLowerCase();
                if ((selectedCategory === "all" || category === selectedCategory) &&
                    (searchInput === "" || productName.includes(searchInput))) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
