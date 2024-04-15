<?php
    include "dbconm.php";
    include "../../sidenav/sidenav.html";
    // SQL query
    $sql = "SELECT * FROM medinfo";
    // Execute query
    $result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Medicine</title>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/medicine.css">    
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Manage Medicine (Current Stock)</h1><hr>
            <table>
                <tbody>
                <tr>
                    <th>Medicine No</th>
                    <th>Medicine Name</th>
                    <th>Medicine Pack</th>
                    <th>Batch ID</th>
                    <th>Expiry Date</th>
                    <th>Generic Name</th>
                    <th>Quantity</th>
                    <th>M.R.P</th>
                    <th>Medicine Supplier</th>
                    <th>Action</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $medno = $row["med_no"];
                        $medname = $row["med_name"];
                        $pack = $row["med_pack"];
                        $gname = $row["gen_name"];
                        $medsup = $row["med_sup"];
                        $quanity = $row["quantity"];
                        $batch = $row["batch_id"];
                        $exp = $row["exp_date"];
                        $mrp = $row["mrp"];
                        //$updateid = $id;

                        echo "
                        <tr>
                        <td>$medno</td>
                        <td>$medname</td>
                        <td>$pack</td>
                        <td>$batch</td>
                        <td>$exp</td>
                        <td>$gname</td>
                        <td>$quanity</td>
                        <td>$mrp</td>
                        <td>$medsup</td>
                        <td>
                        <button id='udt-btn'><a id='udt-btn' href='update.php?updateid= $medno;'>Update</a></button>
                        <button id='del-btn'><a id='del-btn' href='delete.php?deleteid= $medno;'>Delete</a></button>
                        </td>
                        </tr>
                        ";                    
                    }
                } else {
                    echo "<tr><td colspan='4'>0 results</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>