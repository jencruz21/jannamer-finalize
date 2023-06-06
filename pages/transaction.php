<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

?>

            <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Transaction</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table " id="dataTable" width="100%" cellspacing="0">
               <thead>
                   <tr>
                    <th>Transaction ID</th>
                    <th>Transaction Date</th>
                     <th>Customer</th>
                     <th>Status</th>
                     <th width="13%"># of Items</th>
                     <th width="11%">Action</th>
                   </tr>
               </thead>
          <tbody>

<?php
// $query = '';

// if ($_SESSION['TYPE'] === "User") {
//   $id = $_SESSION['MEMBER_ID'];
//   $query = "SELECT cd.*, e.FIRST_NAME, e.LAST_NAME FROM checkout_details cd JOIN employee e ON cd.employee_id = e.EMPLOYEE_ID JOIN vehicle v ON cd.vehicle_id = v.ID WHERE customer_id = '$id'";
// } else {
  
// }

$query = "SELECT cd.*, e.FIRST_NAME, e.LAST_NAME FROM checkout_details cd JOIN employee e ON cd.employee_id = e.EMPLOYEE_ID JOIN vehicle v ON cd.vehicle_id = v.ID";

$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr>
      <td><?= $row['checkout_id'] ?></td>
      <!-- date -->
      <td>
        <?php 
          $str = strtotime($row['checkout_date']);
          echo date("Y-m-d g:i A", $str);
        ?>
      </td>
      <td><?= $row['FIRST_NAME'] ?> <?= $row['LAST_NAME'] ?> </td>
      <td>
        <?php if ($row['checkout_status'] === "0") : ?>
          <img src="../img/loading.png" width="25" height="25" style="margin: auto 0" alt="pending">
            <span style="visibility: hidden; display: hidden;">Pending</span>
          </img>
        <?php else: ?>
          <img src="../img/approved.jpg" width="25" height="25" style="margin: auto 0" alt="approved">
          <span style="visibility: hidden; display: hidden;">Pending</span>
          </img>
        <?php endif; ?>
      </td>
      <td><?= $row['total_items'] ?></td>
      <td align="right">
        <a type="button" class="btn btn-primary bg-gradient-primary" href="trans_view.php?action=edit&id=<?= $row['checkout_id'] ?>&customer_id=<?php echo $row['employee_id']?>"><i class="fas fa-fw fa-th-list"></i> View</a>
      </td>
    </tr>
<?php
  }
?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>

<?php
include '../includes/footer.php';
?>
