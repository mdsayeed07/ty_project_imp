<?php
include("dbcon.php");
include "../../sidenav/sidenav.html";
$error_message = ""; // Initialize error message

// Check if a medicine name is selected
if(isset($_POST['med_name'])) {
    $med_name = $_POST['med_name'];

    // Retrieve batch_id, MRP, and quantity based on selected medicine name
    $sql = "SELECT batch_id, mrp, quantity FROM MEDINFO WHERE med_name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $med_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $batch_id = $row['batch_id'];
        $mrp = $row['mrp'];
        $quantity = $row['quantity'];
    } else {
        // If medicine not found, set batch_id, MRP, and quantity as empty and display error message
        $batch_id = "";
        $mrp = "";
        $quantity = "";
        $error_message = "Medicine not in stock.";
    }
    
    // Return batch_id, MRP, quantity, and error_message as JSON response
    echo json_encode(array("batch_id" => $batch_id, "mrp" => $mrp, "quantity" => $quantity, "error_message" => $error_message));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sales</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/purchase-sale.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Add Sales</h1><hr>
            <form action="process.php" method="post">            
                <label for="invoice">Invoice Number :</label><br>
                <input type="text" name="invoice" placeholder="Invoice Number" required><br><br>

                <label for="med_name">Medicine Name :</label> <br>
                <input type="text" name="med_name" list="medicines" id="meds" placeholder="Select Medicine Name">
                    <!-- Display available quantity next to the medicine name field -->
                    <div class="sp1">
                    <span id="quantity_message" style="color: green;"></span> 
                    <!-- Display error message next to the medicine name field -->
                    <span id="error_message" style="color: red;"><?php echo $error_message; ?></span><br>
                    </div>
                    <datalist id="medicines">
                        <?php 
                            $sql = "SELECT med_name FROM MEDINFO";
                            $result = mysqli_query($conn, $sql);
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Output each medicine name as an option in the datalist
                                    echo '<option value="' . $row['med_name'] . '">';
                                }
                            }
                        ?>
                    </datalist>

                <label for="batch_id">Batch_ID :</label> <br>
                <input type="text" name="batch_id" id="batch_id" disabled><br><br>

                <label for="mrp">MRP :</label><br>
                <input type="text" name="mrp" id="mrp" placeholder="00" disabled><br><br>

                <label for="sprice">Selling Price</label><br>
                <input type="text" name="sprice" id="sprice" placeholder="00"> <br><br>

                <label for="squantity">Sales Quantity</label><br>
                <input type="text" name="squantity" id="squantity" placeholder="00" required> <br> <br>

                <label for="disc">Discount(%)</label><br>
                <input type="text" name="disc" id="disc" placeholder="0%" required> <br> <br>

                <label for="disc">GST(%)</label><br>
                <input type="text" name="gst" id="gst" placeholder="0%" required> <br> <br>

                <label for="total">Total Sales</label> <br>
                <input type="text" name="total" id="total" placeholder="00" disabled><br><br>

                    
                <label for = "payment">Payment Method</label><br>
                    <select name="payment" required>
                        <option disabled selected>-Select Payment Method-</option>
                        <option value="Cash">Cash</option>
                        <option value="UPI">UPI</option>
                        <option value="Net Banking">Net Banking</option>
                    </select><br><br>

                <label for="sdate">Sales Date</label><br>
                <input type = "date" name = "sdate" required><br><br><hr>

                <input type = "submit" value = "Add Sales" name = "submit">
                <input type = "reset" value = "Reset">

                <script>
                    // Function to fetch batch_id, MRP, and quantity based on selected medicine name
                    // Function to fetch batch_id, MRP, and quantity based on selected medicine name
                    document.getElementById('meds').addEventListener('change', function() {
                        var med_name = this.value;
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                var response = JSON.parse(this.responseText);
                                document.getElementById('batch_id').value = response.batch_id;
                                document.getElementById('mrp').value = response.mrp;
                                document.getElementById('error_message').innerText = response.error_message;

                                // Display available quantity message
                                if(response.quantity !== "") {
                                    document.getElementById('quantity_message').innerText = "Available Quantity: " + response.quantity;
                                } else {
                                    document.getElementById('quantity_message').innerText = "";
                                }
                            }
                        };
                        xhttp.open("POST", "addsales.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send("med_name=" + med_name);
                    });

                    // Function to calculate total based on required quantity, MRP, and discount
                    document.getElementById('squantity').addEventListener('input', calculateTotal);
                    document.getElementById('disc').addEventListener('input', calculateTotal);
                    document.getElementById('gst').addEventListener('input',calculateTotal);

                    function calculateTotal() {
                        let squantity = document.getElementById('squantity').value;
                        let availableQuantity = parseInt(document.getElementById('quantity_message').innerText.split(":")[1].trim()); // Extract available quantity from the message
                        let mrp = document.getElementById('mrp').value;
                        let disc = document.getElementById('disc').value;
                        let gst = document.getElementById('gst').value;
                        let sprice = document.getElementById('sprice').value;

                        // Check if the selling price exceeds the MRP
                        if (parseFloat(sprice) > parseFloat(mrp)) {
                            alert('Selling Price cannot exceed MRP');
                            document.getElementById('sprice').value = ''; // Clear the input field
                            return; // Stop further execution
                        }

                        // Check if the required quantity exceeds the available quantity
                        if (parseInt(squantity) > availableQuantity) {
                            alert('Quantity Limit Exceeded');
                            document.getElementById('squantity').value = ''; // Clear the input field
                            return; // Stop further execution
                        }

                        // COST PRICE
                        let actual_price = squantity * mrp;
                        let disc_price = actual_price * (disc / 100);
                        let total_price1 = actual_price - disc_price;

                        // TOTAL SALES
                        let total_sales = total_price1 - sprice;

                        let gst_value = total_sales * (gst / 100);

                        let total = total_sales - gst_value;
                        document.getElementById('total').value = total.toFixed(2);
                    }
                </script>
            </form>
        </div>
    </div>
</body>
</html>