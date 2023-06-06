<?php

require "../includes/connection.php";

$id = mysqli_real_escape_string($db, $_GET['id']);

$query = "DELETE FROM vehicle WHERE ID = '{$id}'";

mysqli_query($db, $query);

header("location: vehicle.php");