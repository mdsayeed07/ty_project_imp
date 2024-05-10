<?php
include "dbcon.php";

if (isset($_GET["deleteid"])) {
    $id = $_GET["deleteid"];
    try {
        // Retrieve the med_name and quantity from the sales table before deleting the record
        $sql_select = "SELECT med_name, quantity FROM sales WHERE sl_no = $id";
        $result_select = mysqli_query($conn, $sql_select);

        if ($result_select && mysqli_num_rows($result_select) > 0) {
            $row = mysqli_fetch_assoc($result_select);
            $med_name = $row['med_name'];
            $quantity = $row['quantity'];

            // Delete the record from the sales table
            $sql_delete = "DELETE FROM sales WHERE sl_no = $id";
            $result_delete = mysqli_query($conn, $sql_delete);

            if ($result_delete) {
                // Update the quantity in the medinfo table
                $sql_update = "UPDATE medinfo SET quantity = quantity + $quantity WHERE med_name = '$med_name'";
                $result_update = mysqli_query($conn, $sql_update);

                if ($result_update) {
                    //echo "<script>alert('Record Deleted and Quantity Updated');</script>";
                    header("location:manages.php");
                    exit();
                } else {
                    echo "<script>alert('Failed to Update Quantity');</script>";
                }
            } else {
                echo "<script>alert('Failed to Delete Record');</script>";
            }
        } else {
            echo "<script>alert('Record Not Found');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Error: {$e->getMessage()}');</script>";
    }
}
?>
