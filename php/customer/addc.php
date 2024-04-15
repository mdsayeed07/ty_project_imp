<?php
    ob_start();
    include "dbcon.php";
    include "../../sidenav/sidenav.html";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/customer.css">
</head>
<body>
    <div class="container-fluid">
        <div class = "container">
            <form action = "addc.php" method = "POST">
                <h1>Add Customer</h1><hr>
                <label for="customer_name">Customer Name :</label><br>
                <input type="text" placeholder="Name" name="customer_name" required><br>

                <label for="customer_contact">Customer Contact :</label><br>
                <input type="text" placeholder="Contact" name="customer_contact" maxlength="10" required><br>

                <label for="customer_address">Customer Address :</label><br>
                <input type="text" placeholder="Address" name="customer_address" required><br>

                <label for="doctor_name">Doctor Name :</label><br>
                <input type="text" placeholder="Doctor Name" name="doctor_name" required><br>

                <label for="doctor_address">Doctor Address :</label><br>
                <input type="text" placeholder="Doctor Address" name="doctor_address" required><br><br><hr>

                <input type="submit" name="submit" value="Add Customer">
                <input type="reset" value="Reset">

            </form>
        </div>
    </div>
</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $cname = filter_input(INPUT_POST,"customer_name", FILTER_SANITIZE_SPECIAL_CHARS);
        $ccontact = filter_input(INPUT_POST,"customer_contact",FILTER_SANITIZE_NUMBER_INT);
        $caddress = $_POST["customer_address"];
        $dname = filter_input(INPUT_POST,"doctor_name",FILTER_SANITIZE_SPECIAL_CHARS);
        $daddress = $_POST["doctor_address"]; 

        try{
            $sql = "INSERT INTO cinfo(c_name,c_contact,c_address,doc_name,doc_address) VALUES('$cname',$ccontact,'$caddress','$dname','$daddress')";
            $result = mysqli_query($conn,$sql);
            if($result){
                //echo "Customer Added!";
                echo "<script>alert('Customer Added!');</script>";
                echo "<script>window.location.href = 'managec.php';</script>";
                //header("location:managec.php");
                exit(); 
            }
        }
        catch(mysqli_sql_exception $e){
            echo "Error: " . $e->getMessage();
        }
    }
    ob_end_flush();
?>