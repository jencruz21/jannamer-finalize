<?php

require "../includes/connection.php";

$id = mysqli_real_escape_string($db, $_GET['id']);

$query = "DELETE FROM product WHERE PRODUCT_ID = '{$id}'";

mysqli_query($db, $query);

header("location: product.php");