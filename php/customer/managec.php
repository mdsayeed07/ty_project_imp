<?php
    include "dbcon.php";
    include "../../sidenav/sidenav.html";

    $sql = "SELECT * FROM cinfo";

// Execute query
    $result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/customer.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Manage Customers</h1><hr>
            <table>
                <tbody>
                    <tr>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Customer Contact</th>
                        <th>Customer Address</th>
                        <th>Doctor Name</th>
                        <th>Doctor Address</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $cid = $row["c_id"];
                            $cname = $row["c_name"];
                            $ccontact = $row["c_contact"];
                            $caddress = $row["c_address"];
                            $dname = $row["doc_name"];
                            $daddress = $row["doc_address"];

                            echo "
                            <tr>
                            <td>$cid</td>
                            <td>$cname</td>
                            <td>$ccontact</td>
                            <td>$caddress</td>
                            <td>$dname</td>
                            <td>$daddress</td>
                            <td>
                            <button id='udt-btn'><a id='udt-btn' href='update.php?updateid= $cid;'>Update</a></button>
                            <button id='del-btn'><a id='del-btn' href='delete.php?deleteid= $cid;'>Delete</a></button>
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