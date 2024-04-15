<?php
    include "dbcon.php";
    include "../../sidenav/sidenav.html";

    // SQL query
    $sql = "SELECT * FROM supinfo";

    // Execute query
    $result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Supplier</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/supplier.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <h1>Table Display</h1><hr>
            <table>
                <tbody>
                <tr>
                    <th>Supplier ID</th>
                    <th>Supplier Name</th>
                    <th>Supplier Email</th>
                    <th>Supplier Contact</th>
                    <th>Supplier Address</th>
                    <th>Action</th>
                </tr>

                <?php

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["sup_id"];
                        $name = $row["sup_name"];
                        $email = $row["sup_email"];
                        $contact = $row["sup_contact"];
                        $address = $row["sup_address"];
                        $updateid = $id;

                        echo "
                        <tr>
                        <td>$id</td>
                        <td>$name</td>
                        <td>$email</td>
                        <td>$contact</td>
                        <td>$address</td>
                        <td>
                        <button id='udt-btn'><a id='udt-btn' href='update.php?updateid= $id;'>Update</a></button>
                        <button id='del-btn'><a id='del-btn' href='delete.php?deleteid= $id;'>Delete</a></button>
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