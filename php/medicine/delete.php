<?php
    include "dbconm.php";
    if(isset($_GET["deleteid"])){
        $id = $_GET["deleteid"];
        try{
            //$sql = "DELETE FROM supinfo WHERE sup_id = $id";
            $sql = "DELETE FROM medinfo WHERE med_no = $id";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo "<script>alert('Record Deleted');</script>";
                //echo "Record Deleted";
                header("location:managem.php");
                exit();
            }
            else{
                echo "<script>alert('Record Not Found!');</script>";
                //echo "Record Not Found!";
            }
            }
        catch(mysqli_sql_exception $e){
            echo "<script>alert('Error: {$e->getMessage()}');</script>";
            //echo "Error: {$e->getMessage()}";
        } 
    }
?>