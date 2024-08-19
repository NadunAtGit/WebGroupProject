
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
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Dashboard/Dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
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
                    <i class=".i-div bx bx-dollar-circle"></i>
                    <h1>$100000</h1>
            </div>
            <p>Today Revenue</p>
            </div>
            <div class="data-div3">
                <div class="inner-div">
                    <i class=".i-div bx bx-user"></i>
                    <h1>$100000</h1>
            </div>
            <p>Today Customers</p>
            </div>
        </div>

        <div class="top-div">
            <div class="data-div4">
                <div class="inner-div">
                        <i class="i-div bx bx-mobile"></i>
                        <h1>1084</h1>
                     

                </div>
                <p>Mobile Phones</p>
                
                
                
            </div>
            <div class="data-div5">
                <div class="inner-div">
                    <i class=".i-div bx bx-laptop"></i>
                    <h1>78</h1>
            </div>
            <p>Laptops</p>
            </div>
            <div class="data-div6">
                <div class="inner-div">
                    <i class=".i-div bx  bx-wrench"></i>
                    <h1>85</h1>
            </div>
            <p>Parts</p>
            </div>
        </div>

        <div class="bottom-div">
            
        </div>

    </div>
</body>
</html>