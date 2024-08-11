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
    <title>Purchases</title>
</head>
<body>
    <div class="container mt-3">
        <div class="box-1 mb-3">
            <button type="button" class="btn btn-primary dynamic-btn" data-bs-toggle="modal" data-bs-target="#purchaseModal">ADD PURCHASE</button>
            <h1>ALL PURCHASES</h1>
        </div>

        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>Stock ID</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Price per Unit</th>
                    <th>Supplier ID</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "SELECT * FROM purchases";
                $result = mysqli_query($connection, $query);
                if (!$result) {
                    die("Query failed: " . mysqli_error($connection));
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["Stock_ID"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Product_ID"]); ?></td>
                            <td><?php echo htmlspecialchars($row["quantity"]); ?></td>
                            <td><?php echo htmlspecialchars($row["price_per_unit"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Supplier_ID"]); ?></td>
                            <td><?php echo htmlspecialchars($row["Date"]); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Duplicate Entry Warning Modal -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'duplicate_entry'): ?>
<div class="modal fade" id="duplicateEntryModal" tabindex="-1" aria-labelledby="duplicateEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="duplicateEntryModalLabel">Warning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>A purchase with the same Stock ID and Product ID already exists.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    var duplicateEntryModal = new bootstrap.Modal(document.getElementById('duplicateEntryModal'));
    duplicateEntryModal.show();
</script>
<?php endif; ?>


                <!-- Add Purchase Modal -->
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="purchaseModalLabel">Add Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="insert_purchase.php">
                    <div class="mb-3">
                        <label for="stock_id" class="form-label">Stock ID</label>
                        <input type="text" class="form-control" id="stock_id" name="stock_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product ID</label>
                        <select class="form-select" id="product_id" name="product_id" required>
                            <option value="" selected disabled>Select Product ID</option>
                            <?php
                            $product_query = "SELECT Product_ID, product_name FROM products";
                            $product_result = mysqli_query($connection, $product_query);
                            while ($product_row = mysqli_fetch_assoc($product_result)) {
                                echo "<option value='" . htmlspecialchars($product_row['Product_ID']) . "'>" . htmlspecialchars($product_row['Product_ID']) . " - " . htmlspecialchars($product_row['product_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_per_unit" class="form-label">Price per Unit</label>
                        <input type="text" class="form-control" id="price_per_unit" name="price_per_unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier ID</label>
                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                            <option value="" selected disabled>Select Supplier ID</option>
                            <?php
                            $supplier_query = "SELECT Supplier_ID, supplier_name FROM suppliers";
                            $supplier_result = mysqli_query($connection, $supplier_query);
                            while ($supplier_row = mysqli_fetch_assoc($supplier_result)) {
                                echo "<option value='" . htmlspecialchars($supplier_row['Supplier_ID']) . "'>" . htmlspecialchars($supplier_row['Supplier_ID']) . " - " . htmlspecialchars($supplier_row['supplier_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="add_purchase">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Product ID Warning Modal -->
    <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_product_id'): ?>
    <div class="modal fade" id="productWarningModal" tabindex="-1" aria-labelledby="productWarningModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productWarningModalLabel">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Product ID is not registered.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var productWarningModal = new bootstrap.Modal(document.getElementById('productWarningModal'));
        productWarningModal.show();
    </script>
    <?php endif; ?>

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
