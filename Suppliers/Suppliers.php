<?php include("../Database/db.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Users/Users.css">
    <title>Document</title>
</head>
<body>
    <div class="container mt-3">
        <div class="box-1 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD SUPPLIERS</button>
            <h1>ALL SUPPLIERS</h1>
        </div>

        <table class="table table-hover table-bordered table-striped" id="xx">
            <thead>
                <tr>
                    <th>SUPPLIER ID</th>
                    <th>NAME</th>
                    <th>TELEPHONE</th>
                    <th>Email</th>
                    <th>ITEMS</th>
                    <th>ACTIONS</th>
                    
                    
                    

                    

                </tr>
            </thead>
            <tbody>
                <?php 
                    $query = "SELECT * FROM suppliers";
                    $result = mysqli_query($connection, $query);
                    if (!$result) {
                        die("Query failed: " . mysqli_error($connection));
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["Supplier_ID"]); ?></td>
                                <td><?php echo htmlspecialchars($row["supplier_name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["telephone"]); ?></td>
                                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                <td><?php echo htmlspecialchars($row["items"]); ?></td>
                                <td>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-<?php echo $row['Supplier_ID']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
            Actions
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-<?php echo $row['Supplier_ID']; ?>">
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $row['Supplier_ID']; ?>">Update</a>
            </li>
            <li>
                <a class="dropdown-item" href="../Suppliers/Delete_Supplier.php?id=<?php echo $row['Supplier_ID']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
            </li>
        </ul>
    </div>
</td>

                            </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../Suppliers/Insert_Suppliers.php">
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Items</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="laptops" name="items[]" value="Laptops">
                                <label class="form-check-label" for="laptops">Laptops</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="phones" name="items[]" value="Phones">
                                <label class="form-check-label" for="phones">Phones</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="parts" name="items[]" value="Parts">
                                <label class="form-check-label" for="parts">Parts</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="add_suppliers">ADD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Supplier Modal -->
    <?php
    mysqli_data_seek($result, 0); // Reset result pointer
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="modal fade" id="updateModal-<?php echo $row['Supplier_ID']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../Suppliers/Update_Supplier.php">
                        <input type="hidden" name="supplier_id" value="<?php echo $row['Supplier_ID']; ?>">
                        <div class="mb-3">
                            <label for="supplier_name-<?php echo $row['Supplier_ID']; ?>" class="form-label">Name</label>
                            <input type="text" class="form-control" id="supplier_name-<?php echo $row['Supplier_ID']; ?>" name="supplier_name" value="<?php echo htmlspecialchars($row['supplier_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telephone-<?php echo $row['Supplier_ID']; ?>" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="telephone-<?php echo $row['Supplier_ID']; ?>" name="telephone" value="<?php echo htmlspecialchars($row['telephone']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email-<?php echo $row['Supplier_ID']; ?>" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email-<?php echo $row['Supplier_ID']; ?>" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Items</label>
                            <?php
                            $items = explode(',', $row['items']);
                            $allItems = ['Laptops', 'Phones', 'Parts'];
                            foreach ($allItems as $item) {
                                $checked = in_array($item, $items) ? 'checked' : '';
                                echo '<div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="' . $item . '-' . $row['Supplier_ID'] . '" name="items[]" value="' . $item . '" ' . $checked . '>
                                    <label class="form-check-label" for="' . $item . '-' . $row['Supplier_ID'] . '">' . $item . '</label>
                                </div>';
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="update_supplier">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>

    <script src="../SideBar/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
