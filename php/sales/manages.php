<?php
    include("dbcon.php");
    include "../../sidenav/sidenav.html";

$sql = "SELECT * FROM sales";

// Execute query
$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Purchase</title>
    <style>
        .content{
            margin-left:210px;
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <!-- <link rel="stylesheet" href="/imp_temp_project/css/purchase-sale.css"> -->
    <link rel="stylesheet" href="/imp_temp_project/css/customer.css">

</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Manage Sales</h1><hr>

            <table>
                <tbody>
                <tr>
                    <th>Invoice No</th>
                    <th>Medicine Name</th>
                    <th>Batch ID</th>
                    <th>Payment Method</th>
                    <th>Quantity</th>
                    <th>Selling Price</th>
                    <th>Discount(%)</th>
                    <th>GST(%)</th>
                    <th>Total Sales</th>
                    <th>Sales Date</th>
                    <th>Action</th>
                </tr>
                <?php

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $invoice = $row["invoice_no"];
                        $medname = $row["med_name"];
                        $batch = $row["batch_id"];
                        $pay = $row["pay_opt"];
                        $quantity = $row["quantity"];
                        $sp = $row["selling_price"];
                        $disc = $row["discount"];
                        $gst = $row["GST"];
                        $sales = $row["total_sales"];
                        $date = $row["sales_date"];
                        
                        $updateid = $row["sl_no"];
                        $deleteid = $row["sl_no"];
                        
                        echo "
                        <tr>
                        <td>$invoice</td>
                        <td>$medname</td>
                        <td>$batch</td>
                        <td>$pay</td>
                        <td>$quantity</td>
                        <td>$sp</td>
                        <td>$disc%</td>
                        <td>$gst%</td>
                        <td>$sales</td>
                        <td>$date</td>
                        <td>
                        <button id='udt-btn'><a id='udt-btn' href='update.php?updateid= $updateid;'>Update</a></button>
                        <button id='del-btn'><a id='del-btn' href='delete.php?deleteid= $deleteid;'>Delete</a></button>
                        </td>
                        </tr>
                        ";
                        
                    }
                } else {
                    echo "<tr><td colspan='4'>0 results</td></tr>";
                }
                ?>
            </tbody>
            </table><hr>
        </div>
    </div>
</body>
</html>