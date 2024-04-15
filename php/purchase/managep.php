<?php
    include("dbcon.php");
    include "../../sidenav/sidenav.html";

$sql = "SELECT * FROM purchase";

// Execute query
$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Purchase</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <!-- <link rel="stylesheet" href="/imp_temp_project/css/purchase-sale.css"> -->
    <link rel="stylesheet" href="/imp_temp_project/css/customer.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Manage Purchases</h1><hr>
            <table>
                <tbody>
                <tr>
                    <th>Invoice No</th>
                    <th>Medicine Name</th>
                    <th>Medicine Supplier</th>
                    <th>Payment Method</th>
                    <th>Batch ID</th>
                    <th>Quantity</th>
                    <th>M.R.P</th>
                    <th>Discount(%)</th>
                    <th>GST(%)</th>
                    <th>Net Purchase</th>
                    <th>Date of Purchase</th>
                    <th>Action</th>
                </tr>
                <?php

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $invoice = $row["invoice_no"];
                        $medname = $row["med_name"];
                        $supplier = $row["supplier"];
                        $pay = $row["pay_opt"];
                        $mrp = $row["mrp"];
                        $quantity = $row["quantity"];
                        $disc = $row["discount"];
                        $gst = $row["GST"];
                        $np = $row["net_purchase"];
                        $batch = $row["batch_id"];
                        $date = $row["purchase_date"];
                        
                        $updateid = $row["sl_no"];
                        $deleteid = $row["sl_no"];
                        
                        echo "
                        <tr>
                        <td>$invoice</td>
                        <td>$medname</td>
                        <td>$supplier</td>
                        <td>$pay</td>
                        <td>$batch</td>
                        <td>$quantity</td>
                        <td>$mrp</td>
                        <td>$disc</td>
                        <td>$gst</td>
                        <td>$np</td>
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