<?php
    include "dbcon.php";

    if(isset($_GET["deleteid"])){
        $id = $_GET["deleteid"];
        try{
            $sql = "DELETE FROM sales WHERE sl_no = $id";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo "<script>alert('Record Deleted');</script>";
                //echo "Record Deleted";
                header("location:manages.php");
                exit();
            }
            else{
                echo "<script>alert('Record Not Found!');</script>";
            }
            }
        catch(mysqli_sql_exception $e){
            echo "<script>alert('Error: {$e->getMessage()}');</script>";
            
        } 
    }
?>