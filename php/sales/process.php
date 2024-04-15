<?php
include("dbcon.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $invoice = filter_input(INPUT_POST, "invoice", FILTER_SANITIZE_SPECIAL_CHARS);
    $med_name = filter_input(INPUT_POST, "med_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $mrp = isset($_POST["mrp"]) ? $_POST["mrp"] : null;
    $sprice = filter_input(INPUT_POST, "sprice", FILTER_VALIDATE_INT);
    $pay = $_POST["payment"];
    $squantity = filter_input(INPUT_POST, "squantity", FILTER_VALIDATE_INT);
    $disc = filter_input(INPUT_POST, "disc", FILTER_SANITIZE_SPECIAL_CHARS);
    $gst = filter_input(INPUT_POST, "gst", FILTER_SANITIZE_SPECIAL_CHARS);
    $total = isset($_POST["total"]) ? $_POST["total"] : null;
    $date = $_POST["sdate"];

    // Query to get batch_id and mrp based on med_name
    $get_batch = "SELECT BATCH_ID,MRP FROM MEDINFO WHERE MED_NAME = ?";
    $stmt = mysqli_prepare($conn, $get_batch);
    mysqli_stmt_bind_param($stmt, "s", $med_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Assigning values fetched from database
        $batch_id = $row['BATCH_ID'];
        $mrp = $row["MRP"];
    } else {
        echo "Error: Batch details not found.";
        exit; // Exit the script if batch details are not found
    }

    // Ensure $total is not null
    if ($total === null) {
        // Calculate prices based on provided data
        $actual_price = $mrp * $squantity;
        $disc_price = $actual_price * ($disc / 100);
        $total_price = $actual_price - $disc_price;
        $total_sales = $total_price - $sprice;
        $gst_value = $total_sales * ($gst / 100);
        $total_sales -= $gst_value;
    }

    // SQL queries
    $update_sql = "UPDATE MEDINFO SET QUANTITY = QUANTITY - ? WHERE MED_NAME = ?";
    $insert_sql = "INSERT INTO SALES (invoice_no, med_name, batch_id, pay_opt, quantity, selling_price, discount, GST, total_sales, sales_date)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and execute SQL statements
    $stmt1 = mysqli_prepare($conn, $insert_sql);
    $stmt2 = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt1, "isssiiddss", $invoice, $med_name, $batch_id, $pay, $squantity, $sprice, $disc, $gst, $total_sales, $date);
    mysqli_stmt_bind_param($stmt2, "is", $squantity, $med_name);

    try {
        $result1 = mysqli_stmt_execute($stmt1);
        $result2 = mysqli_stmt_execute($stmt2);
        if ($result1 && $result2) {
            echo "<script>alert('Sales Added Successfully');</script>";
        } else {
            echo "<script>alert('Failed to add sales');</script>";
        }
        
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
