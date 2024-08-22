<?php
include("../Database/db.php"); // Adjust the path to your database connection

// Initialize variables
$mobilePhones = 0;
$laptops = 0;
$parts = 0;

// Query to get the sum of quantities for each category
$query = "SELECT category, SUM(quantity) as total_quantity FROM products GROUP BY category";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
} else {
    // Fetch and process the results
    while ($row = mysqli_fetch_assoc($result)) {
        switch ($row['category']) {
            case 'Phones':
                $mobilePhones = $row['total_quantity'];
                break;
            case 'Laptop':
                $laptops = $row['total_quantity'];
                break;
            case 'Parts':
                $parts = $row['total_quantity'];
                break;
        }
    }
}

// Close the first PHP block here
?>

<?php
session_start(); // Ensure the session is started
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Dashboard/Dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard">
        <div class="topline">
            <h3><?php echo htmlspecialchars($_SESSION['user_role']); ?> /Dashboard</h3>
        </div>
        <div class="top-div">
            <div class="data-div1">
                <div class="inner-div">
                    <i class="i-div bx bx-dollar-circle"></i>
                    <h1>$100000</h1>
                </div>
                <p>Today Sales</p>
            </div>
            <div class="data-div2">
                <div class="inner-div">
                    <i class="i-div bx bx-dollar-circle"></i>
                    <h1>$100000</h1>
                </div>
                <p>Today Revenue</p>
            </div>
            <div class="data-div3">
                <div class="inner-div">
                    <i class="i-div bx bx-user"></i>
                    <h1>$100000</h1>
                </div>
                <p>Today Customers</p>
            </div>
        </div>

        <div class="top-div">
            <div class="data-div4">
                <div class="inner-div">
                    <i class="i-div bx bx-mobile"></i>
                    <h1><?php echo htmlspecialchars($mobilePhones); ?></h1>
                </div>
                <p>Mobile Phones</p>
            </div>
            <div class="data-div5">
                <div class="inner-div">
                    <i class="i-div bx bx-laptop"></i>
                    <h1><?php echo htmlspecialchars($laptops); ?></h1>
                </div>
                <p>Laptops</p>
            </div>
            <div class="data-div6">
                <div class="inner-div">
                    <i class="i-div bx bx-wrench"></i>
                    <h1><?php echo htmlspecialchars($parts); ?></h1>
                </div>
                <p>Parts</p>
            </div>
        </div>

        <div class="bottom-div">
            <!-- Additional content here -->
        </div>
    </div>
</body>
</html>

