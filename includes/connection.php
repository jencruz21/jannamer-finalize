<?php
 $db = mysqli_connect('arjaicorp.tech', 'u157569420_toolkeeper_sys', 'Youtube21$$') or
        die ('Unable to connect. Check your connection parameters.');
        mysqli_select_db($db, 'u157569420_toolkeeper_sys' ) or die(mysqli_error($db));

// name the db thesis2
// $db = mysqli_connect('localhost', 'root', '') or
//         die ('Unable to connect. Check your connection parameters.');
//         mysqli_select_db($db, 'thesis2' ) or die(mysqli_error($db));
?>