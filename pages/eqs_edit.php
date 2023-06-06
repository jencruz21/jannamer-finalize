<?php
include'../includes/connection.php';
include'../includes/sidebar.php';

?>

<?php

$query = 'SELECT * FROM equipment
WHERE EQUIPMENT_ID ='.$_GET['id'];
  $result = mysqli_query($db, $query) or die(mysqli_error($db));
    while($row = mysqli_fetch_array($result))
    {   
      $zz = $row['EQUIPMENT_ID'];
      $zzz = $row['EQUIPMENT_ID'];
      $A = $row['NAME'];
      $B = $row['DESCRIPTION'];
      $C = $row['QTY_STOCK'];
      $unit = $row['UNITS'];
      $type = $row['TYPE'];
      $status = $row['status'];
      $price = $row['PRICE'];
    }
      $id = $_GET['id'];
?>

  <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Edit Equipment</h4>
            </div>
            <a href="equipment.php?action=add" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
            <div class="card-body">

            <form role="form" method="post" action="eqs_edit1.php">
              <input type="hidden" name="EQUIPMENT_ID" value="<?php echo $zz; ?>" />
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Equipment Code:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Equipment Code" name="EQUIPMENT_CODE" value="<?php echo $zzz; ?>" readonly>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Equipment Name:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Product Name" name="EQNAME" value="<?php echo $A; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Description:
                </div>
                <div class="col-sm-9">
                   <textarea class="form-control" placeholder="Description" name="EQDESCRIPTION"><?php echo $B; ?></textarea>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 UNITS:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="UNITS ex: 2000 Kg" name="UNITS" value="<?php echo $unit; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Quantity:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Quantity" name="EQQTY" value="<?php echo $C; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 PRICE:
                </div>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="₱ 2000" name="PRICE" value="<?php echo $price; ?>" required>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Category:
                </div>
                <div class="col-sm-9">
                    <select name="TYPE" class="form-control" required>
                    <?php $equipment_type_result =  mysqli_query($db, "SELECT type_name FROM equipment_type"); ?>
                        <option value="" <?= is_null($type) && $type === "" ? "selected" : "" ?> disabled >SELECT</option>
                      <?php while ($equipment_type = mysqli_fetch_assoc($equipment_type_result)) : ?>
                        <?php if ($equipment_type['type_name'] === $type) :?>
                          <option value="<?= $equipment_type['type_name'] ?>" selected><?= $equipment_type['type_name'] ?></option>
                        <?php else :?>
                          <option value="<?= $equipment_type['type_name'] ?>"><?= $equipment_type['type_name'] ?></option>  
                        <?php endif; ?>
                      <?php endwhile; ?>
                    </select>
                </div>
              </div>
              <div class="form-group row text-left text-warning">
                <div class="col-sm-3" style="padding-top: 5px;">
                 Status:
                </div>
                <div class="col-sm-9">
                  <!-- select the name of the equipment status -->
                    <select name="status" class="form-control" required>
                      <?php $equipment_status_result =  mysqli_query($db, "SELECT status_name FROM equipment_status"); ?>
                        <option value="" <?= is_null($status) && $status === "" ? "selected" : "" ?> disabled>SELECT</option>
                      <?php while ($equipment_status = mysqli_fetch_assoc($equipment_status_result)) : ?>
                        <?php if ($equipment_status['status_name'] === $status) :?>
                          <option value="<?= $equipment_status['status_name'] ?>" selected><?= $equipment_status['status_name'] ?></option>
                        <?php else :?>
                          <option value="<?= $equipment_status['status_name'] ?>"><?= $equipment_status['status_name'] ?></option>  
                        <?php endif; ?>
                      <?php endwhile; ?>
                    </select>
                </div>
              </div>
              <hr>

                <button type="submit" class="btn btn-warning btn-block"><i class="fa fa-edit fa-fw"></i>Update</button>    
              </form>  
            </div>
          </div></center>

<?php
include'../includes/footer.php';
?>