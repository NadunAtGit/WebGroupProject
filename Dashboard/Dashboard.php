<?php 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title">Nadun Center/<span class="admintitle">Admin</span></span>
                        
                       
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <i class='bx bx-home-alt'></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <i class='bx bxs-devices' ></i>
                        </span>
                        <span class="title">Products</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <i class='bx bxs-shopping-bag' ></i>
                        </span>
                        <span class="title">Make an Order</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <i class='bx bxs-report' ></i>
                        </span>
                        <span class="title">Inventory</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <i class='bx bx-cog' ></i>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>

        

                <li>
                    <a href="#">
                        <span class="icon">
                            <i class='bx bx-log-out' ></i>
                        </span>
                        <span class="title">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <i class='bx bx-menu' ></i>
                </div>

                <div class="search">
                    <i class='bx bx-search-alt-2'></i>
                    <input type="text" placeholder="search" />
                </div>

                <div class="user">
                    
                    <img src="assets/imgs/customer01.jpg" alt="">
                    
                </div>
            </div>

            <!-- ======================= Cards ================== -->
        <div class="cardBox">
                
            
                

                <div class="product--card light-red" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title1">
                                Total Products
                            </span>
                            <span class="value">
                                10000
                            </span>
                        </div>
                        <div class="icon1">
                            <i class='bx bxl-product-hunt' ></i>
                        </div>
                        
                    </div>
    
                </div>

                <div class="product--card light-purple" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title1">
                                Orders
                            </span>
                            <span class="value">
                                10000
                            </span>
                        </div>
                        <div class="icon2">
                            <i class='bx bxl-product-hunt' ></i>
                        </div>
                        
                    </div>
    
                </div>

                <div class="product--card light-green" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title1">
                                Sales
                            </span>
                            <span class="value">
                                10000
                            </span>
                        </div>
                        <div class="icon3">
                            <i class='bx bxl-product-hunt' ></i>
                        </div>
                        
                    </div>
    
                </div>


                <div class="product--card light-blue" >
                    <div class="card--header">
                        <div class="amount">
                            <span class="title1">
                                Users
                            </span>
                            <span class="value">
                                10000
                            </span>
                        </div>
                        <div class="icon4">
                            <i class='bx bxl-product-hunt' ></i>
                        </div>
                        
                    </div>
    
                </div>
                

            </div>
            
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>