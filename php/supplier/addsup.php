<?php
    include "dbcon.php";
    include "../../sidenav/sidenav.html";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/supplier.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <form method = "POST" action="addsup.php">
                <h1>Add Supplier</h1><hr>
                <label for="name">Supplier Name :</label><br>
                <input type="text" placeholder="Name" id="name" name="supname"><br>

                <label for="email">Supplier Email :</label><br>
                <input type="text" placeholder="example@domain.com" id="email" name="supemail"><br>

                <label for="contact">Supplier Contact :</label><br>
                <input type="text" placeholder="Contact" id="contact" name="supcontact"><br>

                <label for="address">Supplier Address :</label><br>
                <input type="text" placeholder="Address" id="address" name="supaddress"><br><br><hr>

                <input type="submit" value="Add Supplier">
                <input type="reset" value="Reset">
            </form>
        </div>
    </div>
</body>
</html>

<?php    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = filter_input(INPUT_POST,"supname",FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'supemail', FILTER_VALIDATE_EMAIL);
        $contact = filter_input(INPUT_POST,"supcontact",FILTER_VALIDATE_INT);
        $address = $_POST["supaddress"];

        try{
            $sql = "INSERT INTO SUPINFO(sup_name,sup_email,sup_contact,sup_address) VALUES('$name','$email',$contact,'$address')";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo "<script>alert('Supplier Added!');</script>";
                echo "<script>window.location.href = 'managesup.php';</script>";
                exit();
            }

            // Add header();
        }
        catch(mysqli_sql_exception $e){
            //echo "Error: " . $e->getMessage();
        }
    }
?>