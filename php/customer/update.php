<?php
ob_start();
include "dbcon.php";
include "../../sidenav/sidenav.html";

if(isset($_GET['updateid'])) {
    $id1 = $_GET['updateid'];
    $sql = "SELECT * FROM cinfo WHERE c_id='$id1'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $name1 = $row["c_name"];
    $contact1 = $row["c_contact"];
    $address1 = $row["c_address"];
    $dname1 = $row["doc_name"];
    $daddress1 = $row["doc_address"];

    if (isset($_POST["submit"])) {
        $name = $_POST["customer_name"];
        $contact = $_POST["customer_contact"];
        $address = $_POST["customer_address"];
        $dname = $_POST["doctor_name"];
        $daddress = $_POST["doctor_address"];

        try {
            $sql_update = "UPDATE cinfo SET c_name = '$name', c_contact = $contact, c_address = '$address', doc_name = '$dname', doc_address = '$daddress' WHERE c_id='$id1'";
            $result_update = mysqli_query($conn, $sql_update);
            if ($result_update) {
                echo "<script>alert(Customer Updated!);</script>";
                echo "<script>window.location.href = 'managec.php';</script>";
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "No customer ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/customer.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <form action="update.php?updateid=<?php echo $id1; ?>" method="POST">
                <h1>Update Customer</h1><hr>
                <label for="customer_name">Customer Name</label><br>
                <input type="text" name="customer_name" value="<?php echo $name1; ?>" required><br>

                <label for="customer_contact">Customer Contact</label><br>
                <input type="text" name="customer_contact" value=<?php echo $contact1; ?> maxlength="10" required><br>

                <label for="customer_address">Customer Address</label><br>
                <input type="text" name="customer_address" value="<?php echo $address1; ?>" required><br>

                <label for="doctor_name">Doctor Name</label><br>
                <input type="text" name="doctor_name" value="<?php echo $dname1; ?>" required><br>

                <label for="doctor_address">Doctor Address</label><br>
                <input type="text" name="doctor_address" value="<?php echo $daddress1; ?>" required><br><br><hr>

                <input type="submit" name="submit" value="Update">
                <input type = "reset" value = "Reset">
            </form>
        </div>
    </div>
</body>
</html>

<?php
    ob_end_flush();
?>