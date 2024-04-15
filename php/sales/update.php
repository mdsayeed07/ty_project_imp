<?php
include "dbcon.php";
include "../../sidenav/sidenav.html";

$id1 = $_GET['updateid'];
$sql = "SELECT * FROM SALES WHERE sl_no = $id1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$invoice1 = $row["invoice_no"];
$medname1 = $row["med_name"];
$sup1 = $row["supplier"];
$pay1 = $row["pay_opt"];
$quantity1 = $row["quantity"];
$mrp1 = $row["mrp"];
$sp1 = $row["selling_price"];
$disc1 = $row["discount"];
$gp1 = $row["gross_profit"];
$gst1 = $row["GST"];
$np1 = $row["net_profit"];
$date1 = $row["sales_date"];

if (isset($_POST["submit"])) {
    $invoice = filter_input(INPUT_POST,"invoice",FILTER_SANITIZE_SPECIAL_CHARS);
    $medname = filter_input(INPUT_POST,"medname",FILTER_SANITIZE_SPECIAL_CHARS);
    $supplier = $_POST["supplier"];
    $pay = $_POST["payment"];
    $quantity = filter_input(INPUT_POST,"squantity",FILTER_VALIDATE_INT);
    $mrp = filter_input(INPUT_POST,"mrp",FILTER_SANITIZE_SPECIAL_CHARS);
    $sprice = filter_input(INPUT_POST,"sprice",FILTER_SANITIZE_SPECIAL_CHARS);
    $disc = filter_input(INPUT_POST,"discount",FILTER_SANITIZE_SPECIAL_CHARS);
    $gst = filter_input(INPUT_POST,"gst",FILTER_SANITIZE_SPECIAL_CHARS);
    $date = $_POST["sdate"];

    // COST PRICE
    $total_quan = $quantity*$mrp;
    $disc_price = $total_quan * ($disc / 100);
    $cost_price = $total_quan - $disc_price;

    // SELLING PRICE
    $total_sp = $sprice * $quantity;
    $disc_sp = $total_sp * ($disc / 100);
    $selling_price = $total_sp - $disc_sp;

    // GROSS PROFIT
    $gprofit = $selling_price - $cost_price;

    // NET PROFIT
    $nprofit = $gprofit - ($gprofit * $gst / 100);
    try {
        
        $sql_update = "UPDATE SALES SET invoice_no = '$invoice', med_name = '$medname', supplier = '$sup', pay_opt = '$pay', quantity = $quantity, mrp = $mrp, selling_price = $sprice,discount=$disc,gross_profit=$gprofit,GST = $gst, net_profit = $nprofit,sales_date = '$date' WHERE sl_no = $id1";
        
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo "Sales Updated!";
            header("location: manages.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Sales</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/customer.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <form method = "POST" action="update.php?updateid=<?php echo $id1; ?>">

            <h1>Update Sales</h1><hr>

            <label for="invoice">Invoice</label><br>
            <input type = "text" name = "invoice" value = '<?php echo $invoice1;?>'required><br><br>

            <label for="medname">Medicine Name</label><br>
            <input type = "text" name = "medname" value = '<?php echo $medname1;?>'required><br><br>

            <label for="supplier">Supplier:</label><br>
            <select name="supplier" required>
                <option value="" disabled selected>-Select Supplier-</option>
                <?php 
                // Fetch values from the supplier table
                $sql = "SELECT sup_name FROM supinfo";
                //$result = $conn->query($sql);
                $result = mysqli_query($conn,$sql);

                // Populate dropdown menu with values from the supplier table
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['sup_name'] . "'>" . $row['sup_name'] . "</option>";
                    }
                }
                ?>
            </select><br><br>

            <label for = "payment">Payment Method</label><br>
            <select name="payment" required>
                    <option value="Cash" <?php if ($pay1 == "Cash") echo "selected"; ?>>Cash</option>
                    <option value="Net Banking" <?php if ($pay1 == "Net Banking") echo "selected"; ?>>Net Banking</option>
                    <option value="UPI" <?php if ($pay1 == "UPI") echo "selected"; ?>>UPI</option>
                    </select><br><br>

            <label for="squantity">Sales Quantity</label><br>
            <input type = "text" name = "squantity" value = '<?php echo $quantity1; ?>'required><br><br>

            <label for="mrp">MRP</label><br>
            <input type = "text" name = "mrp" value = '<?php echo $mrp1; ?>' required><br><br>

            <label for="sprice">Selling Price</label><br>
            <input type = "text" name = "sprice" value = '<?php echo $sp1; ?>' required><br><br>

            <label for="discount">Discount</label><br>
            <input type = "text" name = "discount" value = '<?php echo $disc1; ?>' required><br><br>

            <label for="gst">GST</label><br>
            <input type = "text" name = "gst" value = '<?php echo $gst1; ?>' required><br><br>

            <label for="sdate">Sales Date</label><br>
            <input type = "date" name = "sdate" value = '<?php echo $date1; ?>' required><br><br><hr>

            <input type = "submit" value = "Update Sales" name = "submit">
            <input type = "reset" value = "Reset">

            </form>
        </div>
    </div>
</body>
</html>