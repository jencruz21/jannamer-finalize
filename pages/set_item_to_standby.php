<?php

require("../includes/connection.php");

$id = mysqli_real_escape_string($db, $_GET['id']);

$query = "UPDATE approved_items SET stand_by = 1 WHERE id = '{$id}'";

try {
    //code...
    $result = mysqli_query($db, $query);
    header("location: view_approved.php");
} catch (\Throwable $th) {
    //throw $th;
    die($th);
}