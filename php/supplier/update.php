<?php
include "dbcon.php";
include "../../sidenav/sidenav.html";

$id1 = $_GET['updateid'];
$sql = "SELECT * FROM SUPINFO WHERE sup_id=$id1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name1 = $row["sup_name"];
$email1 = $row["sup_email"];
$contact1 = $row["sup_contact"];
$address1 = $row["sup_address"];

if (isset($_POST["submit"])) {
    $name = $_POST["supname"];
    $email = $_POST["supemail"];
    $contact = $_POST["supcontact"];
    $address = $_POST["supaddress"];

    try {
        $sql = "UPDATE SUPINFO SET sup_name = '$name', sup_email = '$email', sup_contact = $contact, sup_address = '$address' WHERE sup_id=$id1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script>alert('Supplier Updated!');</script>";
            echo "<script>window.location.href = 'managesup.php';</script>";
            exit();
            //header("location: managesup.php");
            //exit();
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
    <title>Update Supplier</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link rel="stylesheet" href="/imp_temp_project/sidenav/css/sidenav.css">
    <link rel="stylesheet" href="/imp_temp_project/css/supplier.css">
</head>
<body>
    <div class="container-fluid">
        <div class="container">
        <h1>Update Supplier</h1><hr>
            <form method="POST" action="update.php?updateid=<?php echo $id1; ?>">
                <label for="name">Supplier Name</label><br>
                <input type="text" id="name" name="supname" value="<?php echo $name1; ?>"><br>

                <label for="email">Supplier Email</label><br>
                <input type="text" id="email" name="supemail" value="<?php echo $email1; ?>"><br>

                <label for="contact">Supplier Contact</label><br>
                <input type="text" id="contact" name="supcontact" maxlength="10" value = <?php echo $contact1; ?>><br>

                <label for="address">Supplier Address</label><br>
                <input type="text" id="address" name="supaddress" value="<?php echo $address1; ?>"><br><br><hr>

                <input type="submit" name="submit" value="Update">
                <input type="reset" value = "Reset">
            </form>
        </div>
    </div>
</body>
</html>
