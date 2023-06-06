<?php
include '../includes/connection.php';
include '../includes/sidebar.php';
include '../includes/helper.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row row-cols">
            <div class="col">
                <h4 class="m-2 font-weight-bold text-primary">Approved Items</h4>
            </div>
            <div class="col">
                <div class="row justify-content-end mr-2">
                    <a href="print_damage_report.php" class="btn btn-primary">Download Damage Report</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row">

            <div class="col">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="30%">Products</th>
                            <th width="15%">Status</th>
                            <th width="10%">Price</th>
                            <th width="15%">Amount approved</th>
                            <th width="15%">Approval</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$query = "SELECT * FROM approved_items WHERE stand_by = 0";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_assoc($result)) {
    ?>
                        <tr>
                            <td><?=$row['name']?></td>
                            <td>
                                <?php if ($row['item_class'] === "M"): ?>
                                    <?php echo checkMaterialStatus($row['status']); ?>
                                <?php else: ?>
                                    <?php echo checkEquipmentStatus($row['status']); ?>
                                <?php endif;?>
                            </td>
                            <td><?=$row['price']?></td>
                            <td><?=$row['qty']?></td>
                            <td>
                                <h6 style="color: green; font-weight:bold">Approved</h6>
                            </td>
                            <td>
                                <?php if (strtolower($row['status']) === "consumed materials"): ?>
                                    <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary"
                                            href="set_item_to_standby.php?id=<?=$row['id']?>">
                                            <i class="fas fa-fw fa-trash"></i> Delete</a>
                                    </div>
                                <?php else: ?>
                                    <div class="btn-group">
                                    <form action="return.php" method="post">
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
                                        <button class="btn btn-primary" name="return"><i
                                                class="fas fa-fw fa-arrow-left"></i> Return</button>
                                    </form>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow"
                                            data-toggle="dropdown" style="color:white;">
                                            <span class="caret"></span><i class="fas fa-fw fa-edit"></i></a>
                                        <ul class="dropdown-menu text-center" role="menu">
                                            <li>
                                                <a type="button" class="btn btn-warning bg-gradient-warning btn-block"
                                                    style="border-radius: 0px;"
                                                    href="approve_items_edit.php?id=<?=$row['id']?>">
                                                    <i class="fas fa-fw fa-edit"></i> Edit
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <?php endif;?>
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