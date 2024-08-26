<?php 
include("../Database/db.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Users/Users.css ">
    <title>Products</title>
</head>
<body>
    <div class="container mt-3">
        <div class="box-1 mb-3">
            <button type="button" class="btn btn-primary dynamic-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD PRODUCT</button>
            <h1>All Products</h1>
        </div>

        <div class="row mb-3">
            <!-- Search bar -->
            <div class="col-12 mb-2">
                <form class="d-flex" role="search" id="searchForm" method="GET" action="">
                    <input class="form-control" type="search" placeholder="Search by Product Name" aria-label="Search" name="search">
                    <button class="btn btn-outline-success ms-2" type="submit">Search</button>
                </form>
            </div>
        </div>

        <table class="table table-hover table-bordered table-striped" id="xx">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Initialize search query
                $search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

                // Modify the query based on search input
                $query = "SELECT * FROM products WHERE product_name LIKE '%$search%'";
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    die("Query failed: " . mysqli_error($connection));
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["Product_ID"]); ?></td>
                            <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["quantity"]); ?></td>
                            <td><?php echo htmlspecialchars($row["category"]); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle dynamic-btn" type="button" id="dropdownMenuButton-<?php echo $row['Product_ID']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-<?php echo $row['Product_ID']; ?>">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $row['Product_ID']; ?>">Update</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="../Products/Delete_Product.php?product_id=<?php echo $row['Product_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Update Modal for each product -->
                        <!-- Update Modal for each product -->
                        <div class="modal fade" id="updateModal-<?php echo $row['Product_ID']; ?>" tabindex="-1" aria-labelledby="updateModalLabel-<?php echo $row['Product_ID']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel-<?php echo $row['Product_ID']; ?>">Update Product: <?php echo htmlspecialchars($row["product_name"]); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="../Products/Update_Product.php">
                                            <input type="hidden" name="product_id" value="<?php echo $row['Product_ID']; ?>">
                                            <div class="mb-3">
                                                <label for="update_product_name-<?php echo $row['Product_ID']; ?>" class="form-label">Product Name</label>
                                                <input type="text" class="form-control" id="update_product_name-<?php echo $row['Product_ID']; ?>" name="product_name" value="<?php echo htmlspecialchars($row["product_name"]); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_quantity-<?php echo $row['Product_ID']; ?>" class="form-label">Quantity</label>
                                                <input type="number" class="form-control" id="update_quantity-<?php echo $row['Product_ID']; ?>" name="quantity" value="<?php echo htmlspecialchars($row["quantity"]); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_category-<?php echo $row['Product_ID']; ?>" class="form-label">Category</label>
                                                <select class="form-select" id="update_category-<?php echo $row['Product_ID']; ?>" name="category" required>
                                                    <option value="" disabled>Select category</option>
                                                    <option value="Laptop" <?php echo $row["category"] === "Laptop" ? "selected" : ""; ?>>Laptop</option>
                                                    <option value="Phones" <?php echo $row["category"] === "Phones" ? "selected" : ""; ?>>Phones</option>
                                                    <option value="Parts" <?php echo $row["category"] === "Parts" ? "selected" : ""; ?>>Parts</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" name="update_product">Update</button>
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


<!-- Add Product Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="../Products/Insert_Product.php">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="" disabled selected>Select category</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Phones">Phones</option>
                            <option value="Parts">Parts</option>
                            
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="add_product">Add</button>
                    </div>
                </form>

    <!-- Add Product Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../Products/Insert_Product.php">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="" disabled selected>Select category</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Phones">Phones</option>
                                <option value="Parts">Parts</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="add_product">Add</button>
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
