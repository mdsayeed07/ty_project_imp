<?php
    
    session_start();

    include("database.php");
    
    session_unset();

    session_destroy();

    mysqli_close($conn);

    echo "<script>alert('Logged Out Successfully!');</script>";
    echo "<script>window.location.href = '/pharmacy_management_system/index.php';</script>";

?>