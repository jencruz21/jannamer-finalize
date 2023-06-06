<?php
include '../includes/connection.php';
?>
<!-- Page Content -->
<div class="col-lg-12">
    <?php
            if (isset($_POST['submit'])) {
                $pc = $_POST['prodcode'];
$name = mysqli_real_escape_string($db, $_POST['name']);
$desc = mysqli_real_escape_string($db, $_POST['description']);
$qty = mysqli_real_escape_string($db, $_POST['quantity']);
$pr = mysqli_real_escape_string($db, $_POST['price']);
$cat = mysqli_real_escape_string($db, $_POST['category']);
$dats = mysqli_real_escape_string($db, $_POST['datestock']);

$query = "INSERT INTO product
                  (PRODUCT_CODE, NAME, DESCRIPTION, QTY_STOCK, PRICE, CATEGORY_ID, DATE_STOCK_IN)
                  VALUES ('{$pc}','{$name}','{$desc}','{$qty}','{$pr}','{$cat}','{$dats}')";
        mysqli_query($db, $query) or die('Error in updating product in Database ' . mysqli_error($db));
            }
?>
    <script type="text/javascript">
    window.location = "product.php";
    </script>
</div>

<?php
include '../includes/footer.php';
?>