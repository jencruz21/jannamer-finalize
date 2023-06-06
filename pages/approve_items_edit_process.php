<?php
include '../includes/connection.php';
$name = $_POST['name'];
$status = $_POST['status'];
$qty = $_POST['qty'];
$item_id = $_POST['id'];

$query = "UPDATE approved_items set 
			name='{$name}',
			qty='{$qty}',
			status='{$status}' WHERE
			id ='{$item_id}'";

try {
	//code...
	$result = mysqli_query($db, $query) or die(mysqli_error($db));
	?>
	<script type="text/javascript">
		alert("You've Updated an Approved Item Successfully.");
		window.location = "view_approved.php";
	</script>
<?php
} catch (\Throwable $th) {
	//throw $th;
	?>
	<script type="text/javascript">
		alert("The Approved Item is not successfully updated");
		window.location = "view_approved.php";
	</script>
<?php
}
?>
