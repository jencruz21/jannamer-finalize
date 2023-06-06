<?php
include'../includes/connection.php';
include'../includes/sidebar.php';

?>

<?php
$id = mysqli_real_escape_string($db, $_GET['id']);

$query = 'SELECT * FROM approved_items WHERE id = "'. $id . '"';
  $result = mysqli_query($db, $query) or die(mysqli_error($db));
    while($row = mysqli_fetch_array($result))
    {   
        $item_id = $row['id'];
        $name = $row['name'];
        $checkout_code = $row['checkout_id'];
        $date_returned = $row['date_approved'];
        $status = $row['status'];
        $item_class = $row['item_class'];
        $qty = $row['qty'];
    }
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Edit Approved Items</h4>
        </div>
        <a href="view_approved.php" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
        <div class="card-body">

            <form role="form" method="post" action="approve_items_edit_process.php">
                <input type="hidden" name="id" value="<?php echo $item_id; ?>" />
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Checkout Code:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Checkout Id" name="checkout_id"
                            value="<?php echo $checkout_code; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Equipment Name:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Equipment Name" name="name" value="<?php echo $name; ?>"
                            required readonly>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Quantity:
                    </div>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" placeholder="Quantity: <?= $qty ?>" name="qty" value="<?php echo $qty; ?>"
                            required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Status:
                    </div>
                    <?php if ($item_class === "M") : ?>
                        <div class="col-sm-9">
                            <select name="status" class="form-control" required>
                                <option selected disabled>SELECT</option>
                                <option value="Excess Materials">Excess Materials</option>
                                <option value="Consumed Materials">Consumed Materials</option>
                            </select>
                        </div>
                    <?php else: ?>
                        <div class="col-sm-9">
                            <select name="status" class="form-control" required>
                                <option selected disabled>SELECT</option>
                                <option value="Brand New">Brand New</option>
                                <option value="Slightly Used">Slightly Used</option>
                                <option value="Used">Used</option>
                                <option value="Heavily Used">Heavily Used</option>
                                <option value="Damaged/Maintenance">Damaged/Maintenance</option>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <hr>

                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button>
            </form>
        </div>
    </div>
</center>

<?php
include'../includes/footer.php';
?>