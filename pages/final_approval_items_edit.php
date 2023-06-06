<?php
include'../includes/connection.php';
include'../includes/sidebar.php';

?>

<?php
$id = mysqli_real_escape_string($db, $_GET['id']);

$query = 'SELECT * FROM returned_items WHERE id = "'. $id . '"';
  $result = mysqli_query($db, $query) or die(mysqli_error($db));
    while($row = mysqli_fetch_array($result))
    {   
        $item_id = $row['id'];
        $name = $row['name'];
        $checkout_code = $row['checkout_id'];
        $date_returned = $row['date_returned'];
        $status = $row['status'];
        $item_class = $row['item_class'];
        $qty = $row['qty'];
    }
?>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Edit Items for Final Returning</h4>
        </div>
        <a href="final_approval_items.php" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
        <div class="card-body">

            <form role="form" method="post" action="final_approval_items_edit1.php">
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
                            required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Quantity Name:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" type="number" placeholder="Quantity <?= $qty?>" name="qty" value="<?php echo $qty; ?>"
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
                <div class="form-group  row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Borrower:
                    </div>
                    <div class="col-sm-9">
                        <?php 
                    $user_result = mysqli_query($db, "SELECT u.ID as ID, u.EMPLOYEE_ID as EMPLOYEE_ID, e.FIRST_NAME as FIRST_NAME, e.LAST_NAME as LAST_NAME FROM users u INNER JOIN employee e ON u.EMPLOYEE_ID = e.EMPLOYEE_ID") 
                ?>
                        <select name="customer_id" class="form-control">
                            <option disabled selected>SELECT</option>
                            <?php while($user = mysqli_fetch_assoc($user_result)) : ?>
                            <option value="<?= $user["ID"]?>"><?= $user["FIRST_NAME"]?>
                                <?= $user["LAST_NAME"]?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group  row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Date Returning:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" type="date" name="date_returned">
                    </div>
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