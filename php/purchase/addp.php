<?php
    include("dbcon.php");
    include "../../sidenav/sidenav.html";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Purchase</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <!-- <link rel="stylesheet" href="/imp_temp_project/css/purchase-sale.css"> -->
    <link rel="stylesheet" href="/imp_temp_project/css/customer.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Add Purchase</h1><hr>
            <form action="addp.php" method="POST">
                <label for="invoice">Invoice Number :</label><br>
                <input type="text" placeholder="Invoice Number" name="invoice" required><br><br>

                <label for="med_name">Medicine Name :</label><br>
                <input type="text" placeholder="Medicine Name" name="med_name" required><br><br>

                <label for="supplier">Supplier :</label><br>                
                <select class="input-20" name="supplier" required>
                    <option disabled selected>-Select Supplier-</option>
                    <?php 
                        
                        $sql = "SELECT sup_name FROM supinfo";
                        //$result = $conn->query($sql);
                        $result = mysqli_query($conn,$sql);
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['sup_name'] . "'>" . $row['sup_name'] . "</option>";
                            }
                        }
                        ?>
                    </select><br><br>
                    
                <label class="name-20" for="payment">Payment Option :</label><br>                   
                    <select class="input-20" name="payment" required>
                        <option disabled selected>Select Payment Method</option>
                        <option value="Cash">Cash</option>
                        <option value="UPI">UPI</option>
                        <option value="Net Banking">Net Banking</option>
                    </select><br><br>

                <label for="batch_id">Batch ID:</label><br>
                <input type="text" placeholder="Batch ID" name="batch_id" required><br><br>
                
                <label for="quantity">Purchase Quantity :</label><br>
                <input type="text" placeholder="00" name="rquantity" required><br><br>

                <label for="mrp">MRP :</label><br>
                <input type="text" placeholder="00" name="mrp" required><br><br>
                
                <label for="discount">Discount :</label><br>
                <input type="text" placeholder="0%" name="discount" required><br><br>

                <label for="gst">GST :</label><br>
                <input type="text" name="gst"><br><br>

                <label>Date of Purchase :</label><br>
                <input type="date" name="date"><br><br><hr>

                <input type = "submit" name = "submit" value = "Add Purchase">
                <input type = "reset" value = "Reset">
            </form>
        </div>
    </div>
</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $invoice = $_POST["invoice"];
        $medname = filter_input(INPUT_POST,"med_name",FILTER_SANITIZE_SPECIAL_CHARS);
        $payment = $_POST["payment"];
        $quantity = filter_input(INPUT_POST,"rquantity",FILTER_VALIDATE_INT);
        $mrp = filter_input(INPUT_POST,"mrp",FILTER_VALIDATE_INT);
        $disc = filter_input(INPUT_POST,"discount",FILTER_VALIDATE_INT);
        $batch = filter_input(INPUT_POST,"batch_id",FILTER_SANITIZE_SPECIAL_CHARS);
        $gst = filter_input(INPUT_POST,"gst",FILTER_SANITIZE_SPECIAL_CHARS);
        $date = $_POST["date"];
        $supplier = $_POST["supplier"];
        
        // Price Calculation
        $total = $quantity*$mrp;
        $disc_rate = $total*($disc/100);
        $actual_rate = $total - $disc_rate;
        $net_purchase = $actual_rate - ($actual_rate*$gst/100);

        $sql = "INSERT INTO PURCHASE(invoice_no,med_name,supplier,pay_opt,batch_id,quantity,mrp,discount,GST,net_purchase,purchase_date)VALUES($invoice,'$medname','$supplier','$payment','$batch',$quantity,$mrp,$disc,$gst,$net_purchase,'$date')";

        $query = "SELECT COUNT(*) as count FROM medinfo WHERE med_name = '$medname'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $medicine_exists = $row['count'];
        $sql_update = "UPDATE MEDINFO SET quantity = quantity + $quantity WHERE med_name = '$medname'";
        if ($medicine_exists) {
            try{
                $result3 = mysqli_query($conn,$sql);
                $result4 = mysqli_query($conn, $sql_update);
                if($result3 and $result4){
                    echo "<script>alert('Purchase and Update Done Successfully!');</script>";
                    echo "<script>window.location.href = 'managep.php';</script>";
                    //header("location: managep.php");
                    exit();
                }
            }
            catch(mysqli_sql_exception $e){
                echo "Error: " . $e->getMessage();
            }  
        }
        else{
            try{
                $result1 = mysqli_query($conn,$sql);
                if($result1)
                {
                    echo "<script>alert('Purchase Added!');</script>";
                    echo "<script>window.location.href = 'managep.php';</script>";
                    exit();
                }
            }
            catch(mysqli_sql_exception $e){
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>