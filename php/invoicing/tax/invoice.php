<?php
    ob_start();
    include "../../../sidenav/sidenav.html";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Invoice</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/invoice.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Manage Tax Invoice</h1><hr>
            <table>
                <thead>
                    <tr>
                        <th>Sl No</th> <!-- New column -->
                        <th>Invoice No</th>
                        <th>Medicine Name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("dbcon.php"); // Assuming dbcon.php contains database connection code

                    // Query to select all records from the 'sales' table
                    $sql = "SELECT * FROM sales";

                    // Execute query
                    $result = mysqli_query($conn, $sql);

                    // Check for errors
                    if (!$result) {
                        die("Query failed: " . mysqli_error($conn));
                    }

                    // Counter variable to keep track of the serial number
                    $serialNo = 1;

                    // Fetching and displaying data
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $invoice = htmlspecialchars($row["invoice_no"]); // Sanitize output
                            $medname = htmlspecialchars($row["med_name"]);
                            $date = htmlspecialchars($row["sales_date"]);
                            $batchId = htmlspecialchars($row["batch_id"]);
                            $quantity = htmlspecialchars($row["quantity"]);
                            $sp = htmlspecialchars($row["selling_price"]);
                            $discount = htmlspecialchars($row["discount"]);
                            $gst = htmlspecialchars($row["GST"]);
                            $totalSales = htmlspecialchars($row["total_sales"]);
                            $pay = htmlspecialchars($row["pay_opt"]);

                            echo "<tr>
                                    <td>$serialNo</td>
                                    <td>$invoice</td>
                                    <td>$medname</td>
                                    <td>$date</td>
                                    <td><button id='prt-btn' onclick='printInvoice(\"$invoice\", \"$medname\", \"$date\", \"$batchId\", \"$quantity\", \"$sp\" ,\"$discount\", \"$gst\", \"$totalSales\",\"$pay\")'>Print Invoice</button></td>
                                </tr>";
                            
                            // Increment serial number for next row
                            $serialNo++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>0 results</td></tr>";
                    }
                    ?>
                </tbody>
            </table><hr>
        </div>
        <script>
            function printInvoice(invoiceNo, medName, salesDate, batchId, quantity, sp,discount, gst, totalSales, pay) {
                var printWindow = window.open('', '', 'height=400,width=800');
                printWindow.document.write('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Printable Invoice</title><style>body {margin: 0;padding: 0;font-family: Arial, sans-serif;text-align: center;}h1, h2, p {margin: 0;padding: 0;}table {width: 100%;border-collapse: collapse;}th, td {border: 1px solid black;padding: 8px;text-align: left;}</style></head><body>');
                printWindow.document.write('<h1>Maharashtra Medical</h1>');
                printWindow.document.write('<p>Shop 6, Chandresh Society, Station Road,</p>');
                printWindow.document.write("<p>Nallasopara(W), Palghar, Maharashtra</p>");
                printWindow.document.write("<p style = 'margin-top:2px;'>Tel:02223466672 / 02276346532</p>");
                printWindow.document.write("<p style = 'margin-top:2px;'>(Mob):996757323 / 9978745705</p><br>");
                printWindow.document.write("<h2>Tax Invoice</h2><br>");
                printWindow.document.write("<h4 style = 'text-align:left;'>Payment Mode: " + pay + "</h4>");
                printWindow.document.write("<h4 style = 'text-align:left;'>Date: "+ salesDate +"</h4>");
                printWindow.document.write("<h4 style = 'text-align:left'>GSTIN No - 27AAAAP0267H2ZN</h4>")
                printWindow.document.write('<hr style = "font-weight:bold;"><br>');
                printWindow.document.write("<table border='1'><tr><th>Invoice No</th><th>Description</th><th>Batch ID</th><th>Qty</th><th>Unit Price (Rs.)</th><th>Discount (%)</th><th>GST (%)</th><th>Grand Total</th></tr>");
                printWindow.document.write("<tr><td>" + invoiceNo + "</td><td>" + medName + "</td><td>" + batchId + "</td><td>" + quantity + "</td><td>"+ sp +"</td><td>" + discount + "</td><td>" + gst + "</td><td>" + totalSales + "</td></tr>");
                printWindow.document.write("</table></body></html>");
                printWindow.document.write('<br><hr style = "font-weight:bold;">');
                printWindow.document.write("<h3 style = 'text-align:left; margin-bottom:0;'>Note:</h3><br>");
                printWindow.document.write("<p style = 'text-align:left;'>1) Unit price is always less than the MRP.</p>");
                printWindow.document.write("<p style = 'text-align:left;'>2) Tax Invoice generated is proof that the payment has been settled.</p>");
                printWindow.document.write("<p style = 'text-align:left;'>3) Maxiumum Discount Applicable is 15%.</p>");
                printWindow.document.write("<p style = 'text-align:left;'>4) GST is inclusive of:- <ul><li style = 'text-align:left; margin-top:0;'>2.5% SGST</li><li style = 'text-align:left;'>2.5% CGST</li></ul></p>");
                printWindow.document.write("<p style = 'text-align:left;'>5) Exchange within 3 days with valid tax invoice.</p>");
                printWindow.document.write("<hr style = 'font-weight:bold;'>");
                printWindow.document.close();
                printWindow.print();
            }
        </script>
    </div>
</body>
</html>

<?php
     ob_end_flush();
?>