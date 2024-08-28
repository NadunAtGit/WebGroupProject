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

                <div class="row mb-3">
                    <div class="col">
                        <label for="serialNumberInput" class="form-label">Serial Number:</label>
                        <input type="text" class="form-control" id="serialNumberInput" name="serial_number" required>
                    </div>
                    <div class="col">
                        <label for="discountInput" class="form-label">Discount (%):</label>
                        <input type="number" class="form-control" id="discountInput" name="discount" required>
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
                        <th>Serial Number</th>
                        <th>Quantity</th>
                        <th>Selling Price</th>
                        <th>Discount (%)</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                    <!-- Items will be dynamically added here -->
                </tbody>
            </table>

            <!-- Net Total Display -->
            <div class="row mb-3">
                <div class="col">
                    <label for="netTotal" class="form-label">Net Total:</label>
                    <input type="text" class="form-control" id="netTotal" readonly>
                </div>
            </div>

            <!-- Phone Number Lookup Section -->
            <div class="mb-4">
                <h3>Customer Lookup</h3>
                <div class="row mb-3">
                    <div class="col">
                        <label for="phoneNumberInput" class="form-label">Phone Number:</label>
                        <input type="text" class="form-control" id="phoneNumberInput" name="phone_number" oninput="fetchCustomerName()">
                    </div>
                    <div class="col">
                        <label for="customerNameInput" class="form-label">Customer Name:</label>
                        <input type="text" class="form-control" id="customerNameInput" name="customer_name" readonly>
                    </div>
                </div>
                <span id="customerMessage" class="text-danger"></span>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary" onclick="generatePDF()">Generate PDF</button>
                <button type="button" class="btn btn-success" onclick="proceedPayment()">Proceed Payment</button>
            </div>
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

        function fetchCustomerName() {
            const phoneNumber = document.getElementById('phoneNumberInput').value;
            const customerNameInput = document.getElementById('customerNameInput');
            const customerMessage = document.getElementById('customerMessage');

            if (phoneNumber) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch_customer_name.php?phone_number=' + encodeURIComponent(phoneNumber), true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        if (this.responseText === "No customer found") {
                            customerNameInput.value = '';
                            customerMessage.textContent = "Customer not found. Please add this customer.";
                        } else {
                            customerNameInput.value = this.responseText;
                            customerMessage.textContent = '';
                        }
                    } else {
                        customerNameInput.value = 'Error fetching customer name';
                    }
                };
                xhr.send();
            } else {
                customerNameInput.value = '';
                customerMessage.textContent = '';
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

                // Set the value of the stockDropdown select to the stockID
                document.getElementById('stockDropdown').value = stockID;
            }
        };
        xhr.send();
    }
}


        function addItem() {
            // Get form values
            const productID = document.getElementById('productDropdown').value;
            const stockID = document.getElementById('stockDropdown').value;
            const serialNumber = document.getElementById('serialNumberInput').value;
            const quantity = document.getElementById('quantityInput').value;
            const price = document.getElementById('priceInput').value;
            const discount = document.getElementById('discountInput').value;
            const discountValue = (price * discount) / 100;
            const totalPrice = (price - discountValue) * quantity;

            // Validate inputs
            if (productID && serialNumber && quantity && price && discount) {
                const table = document.getElementById('orderTable');
                const newRow = table.insertRow();

                newRow.insertCell(0).textContent = productID;
                newRow.insertCell(1).textContent = stockID;
                newRow.insertCell(2).textContent = serialNumber;
                newRow.insertCell(3).textContent = quantity;
                newRow.insertCell(4).textContent = price;
                newRow.insertCell(5).textContent = discount;
                newRow.insertCell(6).textContent = totalPrice.toFixed(2);

                // Update net total
                updateNetTotal();

                // Clear form inputs for the next entry
                document.getElementById('salesForm').reset();
            } else {
                alert('Please fill in all fields.');
            }
        }

        function updateNetTotal() {
            const tableRows = document.getElementById('orderTable').rows;
            let netTotal = 0;

            for (let i = 0; i < tableRows.length; i++) {
                netTotal += parseFloat(tableRows[i].cells[6].textContent);
            }

            document.getElementById('netTotal').value = netTotal.toFixed(2);
        }

        function generatePDF() {
            const tableRows = document.getElementById('orderTable').rows;
            let items = [];
            let grandTotal = 0;
            const date = new Date().toLocaleDateString();
            const time = new Date().toLocaleTimeString();
            const customerName = document.getElementById('customerNameInput').value;
            const phoneNumber = document.getElementById('phoneNumberInput').value;

            for (let i = 0; i < tableRows.length; i++) {
                const row = tableRows[i];
                const item = {
                    product_id: row.cells[0].textContent,
                    serial_number: row.cells[1].textContent,
                    quantity: parseInt(row.cells[2].textContent),
                    selling_price: parseFloat(row.cells[3].textContent),
                    discount: parseFloat(row.cells[4].textContent),
                    total_price: parseFloat(row.cells[5].textContent)
                };
                items.push(item);
                grandTotal += item.total_price;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'generate_pdf.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.responseType = 'blob';
            xhr.onload = function() {
                if (this.status === 200) {
                    const url = window.URL.createObjectURL(new Blob([this.response]));
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'order_summary.pdf';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                } else {
                    alert('Error generating PDF.');
                }
            };
            xhr.send(JSON.stringify({ items, grandTotal, date, time, customerName, phoneNumber }));
        }

        function proceedPayment() {
    const tableRows = document.getElementById('orderTable').rows;
    let items = [];
    let grandTotal = 0;

    for (let i = 0; i < tableRows.length; i++) {
        const row = tableRows[i];
        const stock_id = document.getElementById('stockDropdown').value; // Assuming each row has a dropdown for stock_id
        const item = {
            product_id: row.cells[0].textContent,
            stock_id: row.cells[1].textContent,
            serial_number: row.cells[2].textContent,
            quantity: row.cells[3].textContent,
            selling_price: row.cells[4].textContent,
            discount: row.cells[5].textContent,
            total_price: row.cells[6].textContent
        };
        grandTotal += parseFloat(row.cells[6].textContent);
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
                updateNetTotal(); // Reset net total display
                generatePDF(items, grandTotal);
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

