<?php

require "../includes/connection.php";

$id = mysqli_real_escape_string($db, $_GET['checkout_id']);
$customer_id = mysqli_real_escape_string($db, $_GET['customer_id']);


$query = "UPDATE checkout_details SET checkout_status = '1' WHERE checkout_id = '{$id}'";

mysqli_query($db, $query);

header("location: trans_view.php?action=edit&id=$id&customer_id=$customer_id");