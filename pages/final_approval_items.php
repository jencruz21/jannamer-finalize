<?php
include '../includes/connection.php';
include '../includes/sidebar.php';
include '../includes/helper.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Final Approval of Returned Items</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Checkout Code</th>
                            <th>Borrower</th>
                            <th width="10%">Status</th>
                            <th width="10%">Price</th>
                            <th width="10%">Amount Returned</th>
                            <th width="10%">Date Returned</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$query = "SELECT r.*, e.FIRST_NAME, e.LAST_NAME  FROM returned_items r JOIN employee e ON r.employee_id = e.EMPLOYEE_ID WHERE r.return_status = 0";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_assoc($result)) {
    ?>
                        <tr>
                            <td><?=$row['name']?></td>
                            <td><?=$row['checkout_id']?></td>
                            <td><?=$row['FIRST_NAME']?> <?=$row['LAST_NAME']?></td>
                            <td>
                                <?php if ($row['item_class'] === "M") : ?>
                                    <?php echo checkMaterialStatus($row['status']); ?>
                                <?php else: ?>
                                    <?php echo checkEquipmentStatus($row['status']); ?>
                                <?php endif; ?>
                            </td>
                            <td><?=$row['price']?></td>
                            <td><?=$row['qty']?></td>
                            <td>
                                <?php
$date_returned = strtotime($row['date_returned']);
    echo date("Y-m-d", $date_returned);
    ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <?php if ($row['status'] === "Damaged/Maintenance"): ?>
                                    <?php else: ?>
                                        <form action="final_approval_process.php" method="post">
                                            <input type="hidden" name="customer_id" value="<?=$row['employee_id']?>">
                                            <input type="hidden" name="checkout_id" value="<?=$row['checkout_id']?>">
                                            <input type="hidden" name="name" value="<?=$row['name']?>">
                                            <input type="hidden" name="unit" value="<?=$row['unit']?>">
                                            <input type="hidden" name="type" value="<?=$row['type']?>">
                                            <input type="hidden" name="price" value="<?=$row['price']?>">
                                            <input type="hidden" name="status" value="<?=$row['status']?>">
                                            <input type="hidden" name="qty" value="<?=$row['qty']?>">
                                            <input type="hidden" name="item_id" value="<?=$row['item_id']?>">
                                            <input type="hidden" name="item_class" value="<?=$row['item_class']?>">
                                            <button class="btn btn-primary bg-gradient-primary" name="return"><i
                                                    class="fas fa-fw fa-arrow-left"></i> Return</button>
                                        </form>
                                    <?php endif;?>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow"
                                            data-toggle="dropdown" style="color:white;">
                                            <span class="caret"></span><i class="fas fa-fw fa-edit"></i></a>
                                        <ul class="dropdown-menu text-center" role="menu">
                                            <li>
                                                <a type="button" class="btn btn-warning bg-gradient-warning btn-block"
                                                    style="border-radius: 0px;"
                                                    href="final_approval_items_edit.php?id=<?=$row['id']?>">
                                                    <i class="fas fa-fw fa-edit"></i> Edit
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
}
?>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-1 py-1"></div>
</div>
</div>
</div>


<?php
include '../includes/footer.php';
?>