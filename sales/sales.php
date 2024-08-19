<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
</head>
<body>
    <div class="container mt-3">
        <h1>Point of Sale</h1>

        <!-- Form Section -->
        <div class="mb-4">
            <form id="salesForm">
                <div class="row mb-3">
                    <div class="col">
                        <label for="productDropdown" class="form-label">Product:</label>
                        <select class="form-select" id="productDropdown" name="product_id" onchange="fetchStockIDs()">
                            <option value="">Select Product</option>
                            <?php
                            // Fetch products from the purchases table
                            include("../Database/db.php");
                            $productQuery = "SELECT DISTINCT Product_ID FROM purchases";
                            $productResult = mysqli_query($connection, $productQuery);
                            while ($productRow = mysqli_fetch_assoc($productResult)) {
                                echo "<option value='" . $productRow['Product_ID'] . "'>" . htmlspecialchars($productRow['Product_ID']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="stockDropdown" class="form-label">Stock ID:</label>
                        <select class="form-select" id="stockDropdown" name="stock_id" onchange="fetchSellingPrice()">
                            <option value="">Select Stock ID</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="quantityInput" class="form-label">Quantity:</label>
                        <input type="number" class="form-control" id="quantityInput" name="quantity" required>
                    </div>
                    <div class="col">
                        <label for="priceInput" class="form-label">Selling Price:</label>
                        <input type="text" class="form-control" id="priceInput" name="selling_price" readonly>
                    </div>
                </div>
                <button type="button" class="btn btn-success" onclick="addItem()">Add Item</button>
            </form>
        </div>

        <!-- Table Section -->
        <div class="mb-4">
            <h3>Order Summary</h3>
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Stock ID</th>
                        <th>Quantity</th>
                        <th>Selling Price</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                    <!-- Items will be dynamically added here -->
                </tbody>
            </table>

            <button type="button" class="btn btn-success" onclick="proceedPayment()">Proceed Payment</button>
        </div>
    </div>

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript to handle dropdown and form interaction -->
    <script>
        function fetchStockIDs() {
            const productID = document.getElementById('productDropdown').value;
            const stockDropdown = document.getElementById('stockDropdown');
            stockDropdown.innerHTML = '<option value="">Select Stock ID</option>'; // Clear previous options

            if (productID) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_stock_ids.php?product_id=' + productID, true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        const stockIDs = JSON.parse(this.responseText);
                        stockIDs.forEach(function(stock) {
                            const option = document.createElement('option');
                            option.value = stock.Stock_ID;
                            option.text = stock.Stock_ID;
                            stockDropdown.add(option);
                        });
                    }
                };
                xhr.send();
            }
        }

        function fetchSellingPrice() {
            const stockID = document.getElementById('stockDropdown').value;
            if (stockID) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_selling_price.php?stock_id=' + stockID, true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        document.getElementById('priceInput').value = this.responseText;
                    }
                };
                xhr.send();
            }
        }

        function addItem() {
            // Get form values
            const productID = document.getElementById('productDropdown').value;
            const stockID = document.getElementById('stockDropdown').value;
            const quantity = document.getElementById('quantityInput').value;
            const price = document.getElementById('priceInput').value;

            // Validate inputs
            if (productID && stockID && quantity && price) {
                const table = document.getElementById('orderTable');
                const newRow = table.insertRow();

                newRow.insertCell(0).textContent = productID;
                newRow.insertCell(1).textContent = stockID;
                newRow.insertCell(2).textContent = quantity;
                newRow.insertCell(3).textContent = price;

                // Clear form inputs for the next entry
                document.getElementById('salesForm').reset();
            } else {
                alert('Please fill in all fields.');
            }
        }

        function proceedPayment() {
            const tableRows = document.getElementById('orderTable').rows;
            let items = [];

            for (let i = 0; i < tableRows.length; i++) {
                const row = tableRows[i];
                const item = {
                    product_id: row.cells[0].textContent,
                    stock_id: row.cells[1].textContent,
                    quantity: row.cells[2].textContent
                };
                items.push(item);
            }

            if (items.length > 0) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'process_payment.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function() {
                    if (this.status === 200) {
                        alert('Payment processed successfully!');
                        // Clear the order table after successful payment
                        document.getElementById('orderTable').innerHTML = '';
                    } else {
                        alert('Error processing payment.');
                    }
                };
                xhr.send(JSON.stringify(items));
            } else {
                alert('No items to process.');
            }
        }
    </script>
</body>
</html>