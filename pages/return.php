<?php

include "../includes/connection.php";

/**
 * 
 * 1. add items to returning
 * 2. delete items in approved_items
 * 3. add the amount back and update the item if brand new
 * 
 */

if (isset($_POST['return'])) {
    date_default_timezone_set("Asia/Manila");
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $qty = mysqli_real_escape_string($db, $_POST['qty']);
    $unit = mysqli_real_escape_string($db, $_POST['unit']);
    $type = mysqli_real_escape_string($db, $_POST['type']);
    $price = mysqli_real_escape_string($db, $_POST['price']);
    $status = mysqli_real_escape_string($db, $_POST['status']);
    $checkout_id = mysqli_real_escape_string($db, $_POST['checkout_id']);
    $customer_id = mysqli_real_escape_string($db, $_POST['customer_id']);
    $item_id = mysqli_real_escape_string($db, $_POST['item_id']);
    $item_class = mysqli_real_escape_string($db, $_POST['item_class']);
    $date = date("Y-m-d H:i:s");

    $query1 = "INSERT INTO returned_items 
                    (name, 
                    qty, 
                    unit, 
                    type, 
                    price, 
                    status, 
                    checkout_id, 
                    employee_id, 
                    date_returned, 
                    return_status, 
                    item_id,
                    item_class)
                VALUES 
                    ('{$name}', 
                    '{$qty}',     
                    '{$unit}', 
                    '{$type}', 
                    '{$price}', 
                    '{$status}', 
                    '{$checkout_id}', 
                    '{$customer_id}', 
                    '{$date}', 
                    0, 
                    '{$item_id}',
                    '{$item_class}')";
    mysqli_query($db, $query1);

    $query2 = "DELETE FROM approved_items WHERE checkout_id = '{$checkout_id}' AND item_id = '$item_id'";
    mysqli_query($db, $query2);

    // $query3 = "UPDATE equipment SET QTY_STOCK = QTY_STOCK + '$qty' WHERE EQUIPMENT_ID = '$item_id'";
    // mysqli_query($db, $query3);

    header("location: view_approved.php");
}