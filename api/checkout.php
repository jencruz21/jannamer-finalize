<?php
include "../includes/connection.php";
include "vehicle_helper.php";

if (isset($_POST['checkout_id'])) {
    date_default_timezone_set('Asia/Manila');

    $totalCost = mysqli_real_escape_string($db, $_POST['total_cost']);
    $numOfItems = mysqli_real_escape_string($db, $_POST['total_item_count']);
    $amountPaid = mysqli_real_escape_string($db, $_POST['amount_paid']);
    $detail = mysqli_real_escape_string($db, $_POST['detail']);
    $vehicle_id = mysqli_real_escape_string($db, $_POST['vehicle_id']);
    $employee_id = mysqli_real_escape_string($db, $_POST['employee_id']);
    $checkOutId = mysqli_real_escape_string($db, $_POST['checkout_id']);
    $date = date("Y-m-d H:i:s");

    if (checkVehicle($vehicle_id)) { 
        $result = mysqli_query($db, "SELECT JOB_ID FROM employee WHERE EMPLOYEE_ID = '{$employee_id}'");
        $employee = mysqli_fetch_assoc($result);
        $customer_position = $employee['JOB_ID'] === '1' ? "Engineer" : "Employee";

        echo "Customer Position: " . $customer_position . "\n"; 
        echo "Total cost: " . $totalCost . "\n";
        echo "Num of items: " . $numOfItems . "\n";
        echo "Amount paid: " . $amountPaid . "\n";
        echo "Detail: " . $detail . "\n";
        echo "vehicle id: " . $vehicle_id . "\n";
        echo "employee id: " . $employee_id . "\n";
        echo "Checkout id: " .  $checkOutId . "\n";

        $result = mysqli_query($db, "INSERT INTO 
        checkout_details 
            (details, 
            total_items, 
            total_cost, 
            amount_paid, 
            vehicle_id, 
            employee_id, 
            customer_position, 
            checkout_date, 
            checkout_id) 
            VALUES ('{$detail}', 
                '{$numOfItems}', 
                '{$totalCost}', 
                '{$amountPaid}', 
                '{$vehicle_id}', 
                '{$employee_id}', 
                '{$customer_position}', 
                '{$date}', 
                '{$checkOutId}')");
        updateVehicle($vehicle_id, $employee_id, $checkOutId);
        echo mysqli_affected_rows($db);
        mysqli_close($db);
    } else {
        exit();
    }
}
