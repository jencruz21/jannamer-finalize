<?php

include "../includes/connection.php";

if (isset($_POST['approve'])) {
    date_default_timezone_set('Asia/Manila');

    $checkout_id = mysqli_real_escape_string($db, $_POST['checkout_id']);
    $customer_id = mysqli_real_escape_string($db, $_POST['customer_id']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $qty = mysqli_real_escape_string($db, $_POST['amount']);
    $unit = mysqli_real_escape_string($db, $_POST['unit']);
    $type = mysqli_real_escape_string($db, $_POST['type']);
    $price = mysqli_real_escape_string($db, $_POST['price']);
    $status = mysqli_real_escape_string($db, $_POST['status']);
    $item_id = mysqli_real_escape_string($db, $_POST['item_id']);
    $item_class = mysqli_real_escape_string($db, $_POST['item_class']);
    $date = date('Y-m-d H:i:s');

    /**
     * 1. insert record to approved items
     * 2. subtract the item qty from the entered amount
     * 3. set the status to approved!
     */

    // echo "Checkout Id: " . $checkout_id . "<br>";
    // echo "Customer Id: " . $customer_id . "<br>";
    // echo "Name: " . $name . "<br>";
    // echo "Amount: " . $amount . "<br>";
    // echo "Unit: " . $unit . "<br>";
    // echo "Type: " . $type . "<br>";
    // echo "Price: " . $price . "<br>";
    // echo "Status: " . $status . "<br>";
    // echo "Item id: " . $item_id . "<br>";

    $query1 = "INSERT INTO approved_items 
            (name, 
            qty, 
            unit, 
            type, 
            price, 
            status, 
            checkout_id, 
            employee_id, 
            date_approved, 
            item_id,
            item_class)
        VALUES 
            ('{$name}', 
            '{$qty}', 
            '{$unit}' ,
            '{$type}', 
            '{$price}', 
            '{$status}', 
            '{$checkout_id}', 
            '{$customer_id}', 
            '{$date}', 
            '{$item_id}',
            '{$item_class}')";
    mysqli_query($db, $query1);
    echo mysqli_affected_rows($db);

    if ($item_class === "E") {
        $query2 = "UPDATE equipment SET QTY_STOCK = QTY_STOCK - '$qty' WHERE EQUIPMENT_ID = '$item_id'";
        mysqli_query($db, $query2);
    } else if ($item_class === "M") {
        $query2 = "UPDATE product SET QTY_STOCK = QTY_STOCK - '$qty' WHERE PRODUCT_ID = '$item_id'";
    mysqli_query($db, $query2);
    }

    // pwede eto sa id ng mismong sariling items
    $query3 = "UPDATE checkout_items SET checkout_status = '1' WHERE item_id = '$item_id' AND chkout_id = '$checkout_id'";
    mysqli_query($db, $query3);

    header("location: trans_view.php?action=edit&id=$checkout_id&customer_id=$customer_id");
}
