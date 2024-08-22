<?php
session_start(); // Ensure the session is started
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech-Tool SPA</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../Users/Users.css">
    <style>
        #main-content-iframe {
            width: 100%;
            height: 100vh;
            border: none;
            overflow: hidden;
        }

        .main-content {
            /* overflow: hidden;
            width: 100%;
            height: 100vh;
            box-sizing: border-box; */
            padding-top: 30px;
            
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <i class="bx bx-laptop bx-lg"></i>
                <span style="font-size: 1.6rem;">Tech-Tool</span>
            </div>
            <div class="bx bx-menu" id="btn"></div>
        </div>
        <div class="user">
        <img src="<?php echo htmlspecialchars($_SESSION['user_image']); ?>" alt="user" class="user-img" >

            <div>
                <p class="bold"><?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                <p><?php echo htmlspecialchars($_SESSION['user_role']); ?></p>
            </div>
        </div>
        <ul>
            <li>
                <a href="#" onclick="showContent('dashboard'); return false;">
                    <i class="bx bxs-grid-alt"></i>
                    
                    <span class="nav-item">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showContent('products'); return false;" >
                    <i class="bx bx-shopping-bag"></i>
                    <span class="nav-item">Products</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showContent('inventory'); return false;" >
                    <i class="bx bx-package"></i>
                    <span class="nav-item">Inventory</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showContent('purchases'); return false;" >
                    <i class="bx bx-cart"></i>
                    <span class="nav-item">Purchases</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showContent('reports'); return false;" >

                    <i class="bx bx-bar-chart-alt-2"></i>

                    
                    <span class="nav-item">Reports</span>
                </a>
            </li>
            <?php if ($_SESSION['user_role'] !== 'user') { ?>
                <li>
                    <a href="#" onclick="showContent('customers'); return false;" >
                        <i class="bx bx-user"></i>
                        <span class="nav-item">Users</span>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="#" onclick="showContent('suppliers'); return false;" >
                    <i class="bx bx-store"></i>
                    <span class="nav-item">Suppliers</span>
                </a>
            </li>
            <li>
                <a href="../Login/Logout.php" >
                    <i class="bx bx-log-out"></i>
                    <span class="nav-item">Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <iframe id="main-content-iframe" src="" frameborder="0"></iframe>
    </div>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
</script>

    <script>
    function showContent(section) {
        const iframe = document.getElementById('main-content-iframe');

        if (section === 'dashboard') {
            iframe.src = '../Dashboard/Dashboard.php'; // Update with the actual path
        } else if (section === 'products') {
            iframe.src = '../Products/Products.php'; // Update with the actual path
        } else if (section === 'inventory') {
            iframe.src = '../Inventory/inventory.php'; // Update with the actual path
        } else if (section === 'reports') {
            iframe.src = '../Sales/sales.php'; // Update with the actual path
        } else if (section === 'customers') {
            iframe.src = '../Users/Users.php'; // Update with the actual path
        } else if (section === 'suppliers') {
            iframe.src = '../Suppliers/Suppliers.php'; // Update with the actual path
        }
        else if (section === 'purchases') {
            iframe.src = '../Purchases/Purchases.php'; // Update with the actual path
        } else {
            iframe.src = ''; // Clear the iframe if needed
        }
    }
    </script>
</body>
</html>
