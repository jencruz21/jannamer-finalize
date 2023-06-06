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

    $query1 = "UPDATE returned_items SET return_status = 1 WHERE checkout_id = '{$checkout_id}' AND item_id = '{$item_id}'";
    mysqli_query($db, $query1);

    $query2 = "DELETE FROM approved_items WHERE checkout_id = '$checkout_id' AND item_id = '{$item_id}'";
    mysqli_query($db, $query2);

    if ($item_class === "E") {
        $query3 = "UPDATE equipment SET QTY_STOCK = QTY_STOCK + '$qty', status = '$status' WHERE EQUIPMENT_ID = '$item_id'";
        mysqli_query($db, $query3);
        header("location: final_approval_items.php");
    } else if ($item_class === "M") {
        // materials or product
        $query3 = "UPDATE product SET QTY_STOCK = QTY_STOCK + '$qty' WHERE PRODUCT_ID = '$item_id'";
        mysqli_query($db, $query3);
        header("location: final_approval_items.php");
    }
}