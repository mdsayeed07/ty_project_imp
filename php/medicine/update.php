<?php
ob_start();
include "dbconm.php";
include "../../sidenav/sidenav.html";

$name1 = $pack1 = $batch1 = $gname1 = $quantity1 = $mrp1 = $sup1 = '';

    $id1 = $_GET['updateid'];
    $sql = "SELECT * FROM medinfo WHERE med_no= $id1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $name1 = $row["med_name"];
    $pack1 = $row["med_pack"];
    $batch1 = $row["batch_id"];
    $gname1 = $row["gen_name"];
    $quantity1 = $row["quantity"];
    $mrp1 = $row["mrp"];
    $exp1 = $row["exp_date"];
    $sup1 = $row["med_sup"];

    if (isset($_POST["submit"])) {
        $name = $_POST["med_name"];
        $pack = $_POST["packing"];
        $batch = $_POST["batch"];
        $gname = $_POST["gename"];
        $quantity = $_POST["quantity"];
        $mrp = $_POST["mrp"];
        $sup = $_POST["med_sup"];
        $exp = $_POST["exp_date"];
        try {
            $sql_update = "UPDATE medinfo SET med_name = '$name', med_pack = '$pack', batch_id = '$batch', exp_date='$exp',gen_name = '$gname', quantity = $quantity, mrp = $mrp, med_sup = '$sup' WHERE med_no='$id1'";
            $result_update = mysqli_query($conn, $sql_update);
            if ($result_update) {
                echo "<script>alert('Medicine Updated!');</script>";
                echo "<script>window.location.href = 'managem.php';</script>";
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
    <title>Update Medicine</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/medicine.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <form method="post" action="update.php?updateid= <?php echo $id1; ?>">
            <h1>Update Medicine</h1><hr>
            <label for="med_name">Medicine Name:</label>
            <label for="packing" class="am-1">Packing:</label><br>

            <input type="text" name="med_name" class="am50" value = "<?php echo $name1; ?>">
            <input type="text" name="packing" class="am15" size="3" value= "<?php echo $pack1; ?>"><br><br>


            <label for="batch">Batch ID:</label>
            <label for="exp" class="am-2">Expiry Date</label><br>

            <input type="text" class="am50" name="batch" value="<?php echo $batch1; ?>" required>
            <input type="date" class="am15" name="exp_date" value="<?php echo $exp1; ?>" required><br><br>


            <label for="gename">Generic Name:</label>
            <label for="quantity" class="am-3">Quantity:</label>
            <label for="mrp" class="am-4">MRP:</label><br>

            <input type="text" class="am35" name="gename" value= "<?php echo $gname1; ?>" required>
            <input type="text" class="am15" name="quantity" value= <?php echo $quantity1; ?> required>
            <input type="text" class="am15" name="mrp" value= <?php echo $mrp1; ?> required><br><br>


            <label for="med_sup">Supplier:</label><br>
            <select id="supplier" name="med_sup">
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

            <input type="submit" name="submit" value="Update">
            <input type="reset" value ="Reset">
            </form>
        </div>
    </div>
</body>
</html>

<?php
    ob_end_flush();
?>