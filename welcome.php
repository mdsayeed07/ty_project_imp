<?php
    include("sidenav/sidenav.html");
	/*session_start();

// Check if user is logged in
if(isset($_SESSION["username"])) {
    $fname = $_SESSION["username"];
} else {
    // Redirect user to login page if not logged in
    header("Location: login.html");
    exit();
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard </title>
    <link rel = "icon" href = "./images/hands.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="dashboard.css">
    <script>
        function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
            }
        }
        }
    </script>    
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <header>
                <div class="left-dash">
                    <h1>Dashboard</h1>
                    <nobr><i class="fas fa-home">&nbsp; Home</i></nobr>
                </div>
                <div class="right-dash">                    
                    <div class="dropdown">
                        <button onclick="myFunction()" class="dropbtn">
                        </button>
                        
                        <div id="myDropdown" class="dropdown-content">
                            <a href="./logout.php">Logout</a>
                        </div>
                    </div>
                </div>
                
            </header><hr>

            <!-- pending -->
            <!-- Add php to show data -->
            <div>
                <div class="widgets">
                    <div class="widget">
                        <h2>Total Customers</h2>
                        <p>0</p>
                    </div>
                    <div class="widget">
                        <h2>Total Suppliers </h2>
                        <p>0</p>
                    </div>
                    <div class="widget">
                        <h2>Total Medicines</h2>
                        <p>0</p>
                    </div>
                    <div class="widget">
                        <h2>Total Sales</h2>
                        <p>&#8377; 0.00</p>
                    </div>
                    <div class="widget">
                        <h2>Total Purchases</h2>
                        <p>&#8377; 0.00</p>
                    </div>
                </div>
                <hr>

                <div class="quick-actions">
                    <h2>Quick Actions</h2><br>
                    <a href="/imp_temp_project/php/customer/addc.php">Add New Customer</a>
                    <a href="/imp_temp_project/php/sales/addsales.php">Add New Sales</a>
                    <a href="/imp_temp_project/php/supplier/addsup.php">Add New Supplier</a>
                    <a href="/imp_temp_project/php/purchase/addp.php">Add New Purchase</a>
                    <a href="/imp_temp_project/php/medicine/addm.php">Add New Medicine</a>
                </div><br><br><br><hr>

                <!-- pending -->
                <!-- Add php to show data -->
                <div class="reports">
                    <div class="chart">
                        <h2>Sales Report</h2>
                        <div class="in-chart">
                            <h2>Today's Sales : </h2>
                            <h2 style="color: green;">RS. </h2>
                        </div>
                    </div>

                    <div class="chart">
                        <h2>Purchase Report</h2>
                        <div class="in-chart">
                            <h2>Today's Purchase : </h2>
                            <h2 style="color: red;">RS. </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>