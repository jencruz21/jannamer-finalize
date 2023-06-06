<?php
require "../includes/connection.php";

function checkVehicle ($id) {
    global $db;
    $query = "SELECT * FROM vehicle WHERE ID = '$id'";
    $result=mysqli_query($db, $query);
    $vehicle=mysqli_fetch_assoc($result);

    if ((int)$vehicle['AVAILABILITY'] === 1) {
        return true;
    } 
    return false;
}

function updateVehicle($id, $emp_id, $checkout_id) {
    global $db;
    $query = "UPDATE vehicle SET AVAILABILITY = 0, BORROWER_EMP='$emp_id', CHECKOUT_ID='{$checkout_id}' WHERE ID='$id'";
    mysqli_query($db, $query);

    if (mysqli_affected_rows($db) > 1) {
        return true;
    } else {
        return false;
    }
}