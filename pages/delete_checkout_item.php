<?php

include "../includes/connection.php";

$checkout_id = mysqli_real_escape_string($db, $_GET['id']);
$id = mysqli_real_escape_string($db, $_GET['item_id']);
$customer_id = $_GET['customer_id'];

// $query = "DELETE FROM checkout_items WHERE item_id = '$id'";
$query = "UPDATE checkout_items SET checkout_status = 2 WHERE item_id = '{$id}' AND checkout_id = '$checkout_id'";
mysqli_query($db, $query);

header("location: trans_view.php?id=$checkout_id&customer_id=$customer_id&item_id=$id");