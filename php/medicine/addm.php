<?php
    ob_start();
    include("dbconm.php");
    include "../../sidenav/sidenav.html";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Medicine</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/medicine.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Add Medicine</h1><hr>
            <form method="post" action="addm.php" class="grid-container">
                <label for="med_name">Medicine Name :</label>
                <label for="packing" class="am-1">Packing :</label><br>

                <input type="text" name="med_name" placeholder="Medicine Name" class="am50" required>
                <input type="text" name="packing" placeholder="00" size = "4" class="am15" required><br><br>


                <label for="batch">Batch ID :</label>
                <label for="exp" class="am-2">Expiry Date :</label><br>

                <input type="text" name="batch" placeholder="bid" class="am50" required>
                <input type="date" name="exp" class="am15"><br><br>


                <label for="gename">Generic Name :</label>
                <label for="quantity" class="am-3">Quantity:</label>
                <label for="mrp" class="am-4">MRP :</label><br>

                <input type="text" name="gename" placeholder="Generic Name" class="am35" required>
                <input type="text" name="quantity" placeholder="00" class="am15" required>
                <input type="text" name="mrp" placeholder="00" class="am15" required><br><br>


                <label for="supplier">Supplier :</label><br>
                <select id="supplier" name="supplier" required>
                    <option value="" disabled selected>-Select Supplier-</option>
                    <?php 
                    // Fetch values from the supplier table
                    $sql = "SELECT sup_name FROM supinfo";
                    $result = mysqli_query($conn,$sql);

                    // Populate dropdown menu with values from the supplier table
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['sup_name'] . "'>" . $row['sup_name'] . "</option>";
                        }
                    }
                    ?>
                </select><br><br><hr>

                <input type="submit" name="submit" value="Add">
                <input type="reset" value="Reset">
            </form>
        </div>
    </div>
</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $medname = filter_input(INPUT_POST,"med_name",FILTER_SANITIZE_SPECIAL_CHARS);
        $packing = $_POST["packing"];
        $gname = filter_input(INPUT_POST,"gename",FILTER_SANITIZE_SPECIAL_CHARS);
        $batch = $_POST["batch"];
        $quantity = filter_input(INPUT_POST,"quantity",FILTER_VALIDATE_INT);
        $mrp = filter_input(INPUT_POST,"mrp",FILTER_VALIDATE_INT);
        $supplier = $_POST["supplier"];
        $exp = $_POST["exp"];
        
        $sql = "INSERT INTO MEDINFO(med_name,med_pack,batch_id,exp_date,gen_name,quantity,mrp,med_sup)VALUES('$medname','$packing','$batch','$exp','$gname',$quantity,$mrp,'$supplier')";

        try{
            $result = mysqli_query($conn,$sql);
            if($result){
                echo "<script>alert('Medicine Added');</script>";
                echo "<script>window.location.href = 'managem.php';</script>";
                exit();
                //header("location:managem.php");
            }

        }
        catch(mysqli_sql_exception $e){
            echo "Error: " . $e->getMessage();
        }
    }
    ob_end_flush();
?>