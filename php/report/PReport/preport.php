<?php
ob_start();
include("dbcon.php");
include "../../../sidenav/sidenav.html";

// Check if a month parameter is set in the URL, default to all months if not set
if (isset($_GET['month']) && $_GET['month'] >= 1 && $_GET['month'] <= 12) {
    $selectedMonth = $_GET['month'];
} else {
    $selectedMonth = "all";
}

// SQL query to fetch sales data based on selected month or all months
if ($selectedMonth == "all") {
    $sql = "SELECT * FROM purchase";
} else {
    $sql = "SELECT * FROM purchase WHERE MONTH(purchase_date) = $selectedMonth";
}

// Execute query
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Report</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/reports.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Purchase Report</h1><hr>
            <div class="navbar">
                <a href="?month=all">All Year</a>
                <?php
                // Display clickable links for each month
                for ($i = 1; $i <= 12; $i++) {
                    $monthName = date('F', mktime(0, 0, 0, $i, 1));
                    echo "<a href='?month=$i'>$monthName</a>";
                }
                ?>
            </div><hr>

            <table id="purchaseTable">
                <tbody>
                <tr>
                    <th>Invoice No</th>
                    <th>Medicine Name</th>
                    <th>Batch ID</th>
                    <th>Purchase Date</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
                <?php

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $invoice = $row["invoice_no"];
                        $medname = $row["med_name"];
                        $batch = $row["batch_id"];
                        $date = $row["purchase_date"];
                        $quantity = $row["quantity"];
                        $total = $row["net_purchase"];
                        echo "
                            <tr>
                                <td>$invoice</td>
                                <td>$medname</td>
                                <td>$batch</td>
                                <td>$date</td>
                                <td>$quantity</td>
                                <td>$total</td>
                            </tr>
                        ";
                    }

                    // Calculate total amount for the selected month(s)
                    $totalQuery = "SELECT ROUND(SUM(net_purchase), 2) AS total FROM purchase";
                    if ($selectedMonth != "all") {
                        $totalQuery .= " WHERE MONTH(purchase_date) = $selectedMonth";
                    }
                    $totalResult = $conn->query($totalQuery);
                    $totalRow = $totalResult->fetch_assoc();
                    $totalAmount = $totalRow['total'];

                    // Display total row
                    echo "
                        <tr>
                            <td colspan='5'><h3>Total:</h3></td>
                            <td><h2 style='color: green;'>$totalAmount</h2></td>
                        </tr>
                    ";
                } else {
                    echo "<tr><td colspan='6'>0 results</td></tr>";
                }
                ?>
                </tbody>
            </table><hr>

            <div>
                <button class="btn" onclick="printTable()">Print</button>
            </div>
        </div>

        <script>
            function printTable() {
                var monthName = <?php echo $selectedMonth == "all" ? "'All Year'" : "'" . date('F', mktime(0, 0, 0, $selectedMonth, 1)) . "'"; ?>;
                var printWindow = window.open('', '', 'height=400,width=800');
                printWindow.document.write('<link rel="stylesheet" type="text/css" href="table.css">'); // Include external CSS file
                printWindow.document.write('<style>');
                printWindow.document.write('@media print { .navbar { display: none; } }'); // Hide navbar when printing
                printWindow.document.write('#purchaseTable { border-collapse: collapse; width: 100%; }');
                printWindow.document.write('#purchaseTable th, #purchaseTable td { border: 1px solid #dddddd; text-align: left; padding: 8px; }');
                printWindow.document.write('#purchaseTable th { background-color: #f2f2f2; }');
                printWindow.document.write('</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h1 style = "text-align:center;">Maharashtra Medical</h1>');
                printWindow.document.write('<p style = "text-align:center;">Shop 6, Chandresh Society, Station Road,</p>');
                printWindow.document.write("<p style = 'text-align:center;'>Nallasopara(W), Palghar, Maharashtra</p>");
                printWindow.document.write("<p style = 'text-align:center;'>Tel:02223466672 / 02276346532</p>");
                printWindow.document.write("<p style = 'text-align:center;'>(Mob):996757323 / 9978745705</p><br>");
                printWindow.document.write("<hr style = 'font-weight:bold;'>");
                printWindow.document.write("<h2 style = 'text-align:center'>Purchase Report</h2>");
                printWindow.document.write('<h2 style="text-align:center;">' + monthName + ' Report</h2>'); 
                printWindow.document.write(document.getElementById('purchaseTable').outerHTML);
                printWindow.document.write("<br><br><hr>");
                printWindow.document.write('</body></html>');
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