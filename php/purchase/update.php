<?php
include "dbcon.php";
include "../../sidenav/sidenav.html";

$id1 = $_GET['updateid'];
$sql = "SELECT * FROM purchase WHERE sl_no = $id1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$invoice1 = $row["invoice_no"];
$medname1 = $row["med_name"];
$sup1 = $row["supplier"];
$pay1 = $row["pay_opt"];
$quantity1 = $row["quantity"];
$batch1 = $row["batch_id"];
$mrp1 = $row["mrp"];
$disc1 = $row["discount"];
$date1 = $row["purchase_date"];
$gst1 = $row["GST"];

if (isset($_POST["submit"])) {
    $invoice = filter_input(INPUT_POST, "invoice", FILTER_SANITIZE_SPECIAL_CHARS);
    $medname = filter_input(INPUT_POST, "med_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $sup = filter_input(INPUT_POST, "supplier", FILTER_SANITIZE_SPECIAL_CHARS);
    $pay = filter_input(INPUT_POST, "payment", FILTER_SANITIZE_SPECIAL_CHARS);
    $quantity = filter_input(INPUT_POST, "rquantity", FILTER_VALIDATE_INT);
    $mrp = filter_input(INPUT_POST, "mrp", FILTER_VALIDATE_INT);
    $batch = filter_input(INPUT_POST, "batch_ID", FILTER_SANITIZE_SPECIAL_CHARS);
    $disc = $_POST["discount"];
    $date = $_POST["date"];
    $gst = filter_input(INPUT_POST,"gst",FILTER_SANITIZE_SPECIAL_CHARS);

    // Price Calculation
    $total = $quantity*$mrp;
    $disc_rate = $total*($disc/100);
    $actual_rate = $total - $disc_rate;
    $net_purchase = $actual_rate - ($actual_rate*$gst/100);

    try {
        $sql_update = "UPDATE purchase SET invoice_no = $invoice, med_name = '$medname', supplier = '$sup', pay_opt = '$pay', quantity = $quantity, batch_id = '$batch',mrp = $mrp, discount = $disc, GST = $gst, net_purchase = $net_purchase, purchase_date = '$date' WHERE sl_no = $id1";
        $result_update = mysqli_query($conn, $sql_update);
        if ($result_update) {
            echo "Purchase Updated!";
            header("location: managep.php");
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
    <title>Update Purchase</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/customer.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <form method="POST" action="update.php?updateid=<?php echo $id1; ?>">
                <h1>Update Purchase</h1><hr>

                <label for="invoice">Invoice No</label><br>
                <input type="text" name="invoice" value="<?php echo $invoice1; ?>"><br><br>

                <label for="med_name">Medicine Name</label><br>
                <input type="text" name="med_name" value="<?php echo $medname1; ?>"><br><br>

                <label for="supplier">Supplier:</label><br>
                <select name="supplier" required>
                    <option value="" disabled selected>-Select Supplier-</option>
                    <?php 
                    // Fetch values from the supplier table
                    $sql = "SELECT sup_name FROM supinfo";
                    $result = mysqli_query($conn, $sql);

                    // Populate dropdown menu with values from the supplier table
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['sup_name'] . "'>" . $row['sup_name'] . "</option>";
                        }
                    }
                    ?>
                </select><br><br>

                <label for="payment">Payment Option:</label><br>
                <select name="payment" required>
                    <option value="Cash" <?php if ($pay1 == "Cash") echo "selected"; ?>>Cash</option>
                    <option value="Net Banking" <?php if ($pay1 == "Net Banking") echo "selected"; ?>>Net Banking</option>
                    <option value="UPI" <?php if ($pay1 == "UPI") echo "selected"; ?>>UPI</option>
                </select><br><br>

                <label for="batch_id">Batch ID</label><br>
                <input type="text" name = "batch_id" value = "<?php echo $batch1; ?>" required> <br><br>

                <label for="rquantity">Purchase/Required Quantity</label><br>
                <input type="text" name="rquantity" value="<?php echo $quantity1; ?>"><br><br>

                <label for="mrp">MRP</label><br>
                <input type="text" name="mrp" value="<?php echo $mrp1; ?>"><br><br>
                
                <label for="discount">Discount</label><br>
                <input type="text" name="discount" value="<?php echo $disc1; ?>"><br><br>

                <label for="gst">GST</label><br>
                <input type="text" name="gst" value="<?php echo $gst1; ?>"><br><br>

                <label for="date">Date of Purchase</label><br>
                <input type="date" name="date" value="<?php echo $date1; ?>"><br><br><hr>

                <input type="submit" name="submit" value="Update Purchase">
                <input type="reset" value="Reset">
            </form>
        </div>
    </div>
</body>
</html>