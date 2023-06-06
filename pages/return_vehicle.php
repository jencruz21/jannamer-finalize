<?php

require "../includes/connection.php";

$vehicle_id = mysqli_real_escape_string($db, $_GET['vehicle_id']);
$checkout_id = mysqli_real_escape_string($db, $_GET['checkout_id']);
$employee_id = mysqli_real_escape_string($db, $_GET['employee_id']);

$query = "UPDATE vehicle SET AVAILABILITY = 1 WHERE ID = '{$vehicle_id}' AND BORROWER_EMP = {$employee_id}";
mysqli_query($db, $query);

echo "Query Executed <br>";
echo mysqli_affected_rows($db);
if (mysqli_affected_rows($db) >= 1) {
    header("location: trans_view.php?action=edit&id={$checkout_id}&customer_id={$employee_id}");
} else {
    header("location: trans_view.php?action=edit&id={$checkout_id}&customer_id={$employee_id}");
}