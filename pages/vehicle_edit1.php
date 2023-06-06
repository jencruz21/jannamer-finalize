<?php
include '../includes/connection.php';

$id = $_GET['id'];
$name = $_POST['name'];
$plate_no = $_POST['plate_no'];
$date_borrowed = $_POST['date_borrowed'];
$start_change_oil = $_POST['start_change_oil'];
$end_change_oil = $_POST['end_change_oil'];
$registration_date = $_POST['registration_date'];
$expiration_date = $_POST['expiration_date'];

$query = "UPDATE vehicle set 
            NAME='$name', 
            PLATE_NO = '{$plate_no}',
			DATE_BORROWED='$date_borrowed',
			start_change_oil='$start_change_oil',
            end_change_oil='$end_change_oil', 
            registration_date='$registration_date', 
            expiration_date='$expiration_date' 
            WHERE ID ='$id'";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
?>
	<script type="text/javascript">
			alert("You've updated a Vehicle Successfully.");
			window.location = "vehicle.php";
		</script>
