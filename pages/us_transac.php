<?php
include'../includes/connection.php';
include "session.php";
?>
          <!-- Page Content -->
          <div class="col-lg-12">
            <?php
              $emp = $_POST['empid'];
              $user = $_POST['username'];
              $pass = $_POST['password'];
              $pass = sha1($pass);
              $positionId = $_SESSION['POSITION_ID'];
              if (isset($_GET['action'])) {
                  if ($_GET['action'] === 'add') {
                    $query = "INSERT INTO users
                    (ID, EMPLOYEE_ID, USERNAME, PASSWORD, TYPE_ID, POSITION_ID)
                    VALUES (Null,'{$emp}','{$user}','{$pass}','2', '$positionId')";
                    mysqli_query($db,$query)or die ('Error in updating users in '. $query);
                  }
              }
            ?>
              <script type="text/javascript">window.location = "user.php";</script>
          </div>

<?php
include'../includes/footer.php';
?>