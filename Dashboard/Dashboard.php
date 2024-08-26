<?php
include("../Database/db.php"); // Adjust the path to your database connection

// Initialize variables
$mobilePhones = 0;
$laptops = 0;
$parts = 0;
$todaySales = 0; // Variable for today's sales
$todayCustomers = 0; // Variable for today's customers
$totalItemsSold = 0; // Variable for total items sold today

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

// Query to get today's sales
$today = date('Y-m-d'); // Assuming date format is YYYY-MM-DD
$salesQuery = "SELECT SUM(Total) as total_sales, COUNT(*) as customer_count FROM sales WHERE DATE(Date) = ?";
$salesStmt = mysqli_prepare($connection, $salesQuery);

if (!$salesStmt) {
    die("Failed to prepare statement: " . mysqli_error($connection));
}

mysqli_stmt_bind_param($salesStmt, "s", $today);
mysqli_stmt_execute($salesStmt);
mysqli_stmt_bind_result($salesStmt, $todaySales, $todayCustomers);
mysqli_stmt_fetch($salesStmt);
mysqli_stmt_close($salesStmt);

// Query to get total items sold today
$itemsQuery = "SELECT items FROM sales WHERE DATE(Date) = ?";
$itemsStmt = mysqli_prepare($connection, $itemsQuery);

if (!$itemsStmt) {
    die("Failed to prepare statement: " . mysqli_error($connection));
}

mysqli_stmt_bind_param($itemsStmt, "s", $today);
mysqli_stmt_execute($itemsStmt);
mysqli_stmt_bind_result($itemsStmt, $itemsSerialized);

while (mysqli_stmt_fetch($itemsStmt)) {
    $items = json_decode($itemsSerialized, true);
    foreach ($items as $item) {
        $totalItemsSold += $item['quantity'];
    }
}

mysqli_stmt_close($itemsStmt);

// Query to get sales for the last 4 days
$sales4DaysQuery = "
    SELECT DATE(Date) as sale_date, SUM(Total) as daily_sales
    FROM sales
    WHERE DATE(Date) >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)
    GROUP BY DATE(Date)
    ORDER BY DATE(Date) ASC
";
$sales4DaysResult = mysqli_query($connection, $sales4DaysQuery);

if (!$sales4DaysResult) {
    die("Query failed: " . mysqli_error($connection));
}

$salesData = [];
while ($row = mysqli_fetch_assoc($sales4DaysResult)) {
    $salesData[] = [
        'date' => $row['sale_date'],
        'sales' => $row['daily_sales']
    ];
}

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Dashboard</title>
</head>
<body>
    <div class="dashboard">
        <div class="topline">
            <h3><?php echo htmlspecialchars($_SESSION['user_role']); ?> /Dashboard</h3>
        </div>
        <div class="top-div">
            <div class="data-div">
                <div class="inner-div">
                    <i class="i-div bx bx-dollar-circle"></i>
                    <h1>$10000</h1>
                </div>
                <p>Today Sales</p>
            </div>
            <div class="data-div">
                <div class="inner-div">
                    <i class="i-div bx bx-dollar-circle"></i>
                    <h1><?php echo htmlspecialchars('$' . number_format($todaySales, 2)); ?></h1>
                </div>
                <p>Today Revenue</p>
            </div>
            <div class="data-div3">
                <div class="inner-div">
                    <i class="i-div bx bx-user"></i>
                    <h1><?php echo htmlspecialchars($todayCustomers); ?></h1>
                </div>
                <p>Today Customers</p>
            </div>
            <div class="data-div">
                <div class="inner-div">
                    <i class="i-div bx bx-box"></i>
                    <h1><?php echo htmlspecialchars($totalItemsSold); ?></h1>
                </div>
                <p>Items Sold Today</p>
            </div>
        </div>
        <hr class="my-4">

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
        <hr class="my-4">
        <div class="bottom-div">
            <!-- Additional content here -->
            <canvas id="salesChart" style="width: 300px; height: 150px;"></canvas>
        </div>
    </div>

    <script>
        const salesData = <?php echo json_encode($salesData); ?>;
        const labels = salesData.map(data => data.date);
        const data = salesData.map(data => data.sales);

        // Define colors for each column
        const colors = [
            'rgba(75, 192, 192, 0.2)', // Color for the first column
            'rgba(255, 99, 132, 0.2)', // Color for the second column
            'rgba(255, 159, 64, 0.2)', // Color for the third column
            'rgba(153, 102, 255, 0.2)'  // Color for the fourth column
        ];

        // Create the chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales for the Last 4 Days',
                    data: data,
                    backgroundColor: colors,
                    borderColor: colors.map(color => color.replace('0.2', '1')), // Use the same colors but with full opacity for borders
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Sales'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>


</html>