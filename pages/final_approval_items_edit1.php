<?php
include '../includes/connection.php';
$name = $_POST['name'];
$status = $_POST['status'];
$date_returned = $_POST['date_returned'];
$customer_id = $_POST['customer_id'];
$item_id = $_POST['id'];

$query = 'UPDATE returned_items set name="' . $name . '",
					status="' . $status . '", date_returned="' . $date_returned . '", customer_id ="' . $customer_id . '" WHERE
					id ="' . $item_id . '"';

try {
	//code...
	$result = mysqli_query($db, $query) or die(mysqli_error($db));
	?>
	<script type="text/javascript">
		alert("You've Updated an Item for Final Returning Successfully.");
		window.location = "final_approval_items.php";
	</script>
<?php
} catch (\Throwable $th) {
	//throw $th;
	?>
	<script type="text/javascript">
		alert("The Item for Final Releasing is not successfully updated");
		window.location = "final_approval_items.php";
	</script>
<?php
}
?>
