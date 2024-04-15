<?php
    $servername = "localhost";
    $username = "root"; // default username for XAMPP
    $password = "";     // default password for XAMPP
    //$database = "users"; // replace with your actual database name
    $database = "pharmacy1";
    // Create connection
    try{
        $conn = new mysqli($servername, $username, $password, $database);
        // $conn1 = mysqli_connect($servername, $username, $password, $database);
    }
    catch(mysqli_sql_exception $e) {
        //echo "Sorry! Connection Failed!";
    }
    if($conn){
        //echo "Connected Successfully!";
    }
?>