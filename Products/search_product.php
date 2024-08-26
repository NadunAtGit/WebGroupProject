<?php 
include("../Database/db.php"); 

// Initialize search query
$search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

// Modify the query based on search input
$query = "SELECT * FROM products WHERE product_name LIKE '%$search%'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
} else {
    // Output results in table format
    echo '<table class="table table-hover table-bordered table-striped" id="xx">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Product ID</th>';
    echo '<th>Product Name</th>';
    echo '<th>Quantity</th>';
    echo '<th>Category</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["Product_ID"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["product_name"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["quantity"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["category"]) . '</td>';
        echo '<td>';
        echo '<div class="dropdown">';
        echo '<button class="btn btn-secondary dropdown-toggle dynamic-btn" type="button" id="dropdownMenuButton-' . $row['Product_ID'] . '" data-bs-toggle="dropdown" aria-expanded="false">';
        echo 'Actions';
        echo '</button>';
        echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row['Product_ID'] . '">';
        echo '<li>';
        echo '<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateModal-' . $row['Product_ID'] . '">Update</a>';
        echo '</li>';
        echo '<li>';
        echo '<a class="dropdown-item" href="../Products/Delete_Product.php?product_id=' . $row['Product_ID'] . '" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a>';
        echo '</li>';
        echo '</ul>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';

        // Update Modal for each product
        echo '<div class="modal fade" id="updateModal-' . $row['Product_ID'] . '" tabindex="-1" aria-labelledby="updateModalLabel-' . $row['Product_ID'] . '" aria-hidden="true">';
        echo '<div class="modal-dialog" role="document">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="updateModalLabel-' . $row['Product_ID'] . '">Update Product: ' . htmlspecialchars($row["product_name"]) . '</h5>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '<form method="post" action="../Products/Update_Product.php">';
        echo '<input type="hidden" name="product_id" value="' . $row['Product_ID'] . '">';
        echo '<div class="mb-3">';
        echo '<label for="update_product_name-' . $row['Product_ID'] . '" class="form-label">Product Name</label>';
        echo '<input type="text" class="form-control" id="update_product_name-' . $row['Product_ID'] . '" name="product_name" value="' . htmlspecialchars($row["product_name"]) . '" required>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label for="update_quantity-' . $row['Product_ID'] . '" class="form-label">Quantity</label>';
        echo '<input type="number" class="form-control" id="update_quantity-' . $row['Product_ID'] . '" name="quantity" value="' . htmlspecialchars($row["quantity"]) . '" required>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label for="update_category-' . $row['Product_ID'] . '" class="form-label">Category</label>';
        echo '<select class="form-select" id="update_category-' . $row['Product_ID'] . '" name="category" required>';
        echo '<option value="" disabled>Select category</option>';
        echo '<option value="Laptop" ' . ($row["category"] === "Laptop" ? "selected" : "") . '>Laptop</option>';
        echo '<option value="Phones" ' . ($row["category"] === "Phones" ? "selected" : "") . '>Phones</option>';
        echo '<option value="Parts" ' . ($row["category"] === "Parts" ? "selected" : "") . '>Parts</option>';
        echo '</select>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
        echo '<button type="submit" class="btn btn-success" name="update_product">Update</button>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</tbody>';
    echo '</table>';
}
?>
