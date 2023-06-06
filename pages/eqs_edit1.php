<?php
include '../includes/connection.php';
$zz = $_POST['EQUIPMENT_ID'];
$pc = $_POST['EQUIPMENT_CODE'];
$pname = $_POST['EQNAME'];
$desc = $_POST['EQDESCRIPTION'];
$pr = $_POST['EQQTY'];
$units = $_POST['UNITS'];
$cat = $_POST['TYPE'];
$status = $_POST['status'];
$price = $_POST['PRICE'];

$query = "UPDATE equipment SET NAME='$pname', DESCRIPTION='$desc', UNITS='$units', QTY_STOCK='$pr', TYPE='$cat', status='$status', PRICE='{$price}' WHERE EQUIPMENT_ID='$zz'";

try {
	//code...
	$result = mysqli_query($db, $query) or die(mysqli_error($db));
	?>
	<script type="text/javascript">
		alert("You've Update Product Successfully.");
		window.location = "equipment.php";
	</script>
<?php
} catch (\Throwable $th) {
	//throw $th;
	?>
	<script type="text/javascript">
		alert("The product is not successfully updated");
		window.location = "equipment.php";
	</script>
<?php
}
?>
