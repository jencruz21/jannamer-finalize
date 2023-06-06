<?php

require "../includes/connection.php";

$id = mysqli_real_escape_string($db, $_GET['id']);

$query = "DELETE FROM equipment WHERE EQUIPMENT_ID = '{$id}'";

mysqli_query($db, $query);

header("location: equipment.php");