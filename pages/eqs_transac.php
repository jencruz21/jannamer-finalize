<?php
include '../includes/connection.php';
?>
<!-- Page Content -->
<div class="col-lg-12">
    <?php
$ename = $_POST['NAME'];
$edesc = $_POST['DESCRIPTION'];
$eqty = $_POST['QTY_STOCK'];
$ecat = $_POST['TYPE'];
$price = $_POST['price'];
$unit = $_POST['unit'];
$edats = $_POST['DATE_PURCHASED'];

switch ($_GET['action']) {
    case 'add':
        $query = "INSERT INTO equipment
                  (NAME, DESCRIPTION, QTY_STOCK, TYPE, DATE_PURCHASED, UNITS, PRICE, status)
                  VALUES ('{$ename}','{$edesc}','{$eqty}','{$ecat}','{$edats}', '{$unit}', '{$price}', 'Brand New')";
        mysqli_query($db, $query) or die('Error in updating equipment in Database ' . $query);
        break;
}
?>
    <script type="text/javascript">window.location = "equipment.php";</script>
</div>

<?php
include '../includes/footer.php';
?>