<?php
include'../includes/connection.php';
?>
<!-- Page Content -->
<div class="col-lg-12">
    <?php
              $name = $_POST['Name'];
              $plate_no = $_POST['PlateNo'];
              $date_borrowed = $_POST['date_borrowed'];
              $start_change_oil = $_POST['start_change_oil'];
              $end_change_oil = $_POST['end_change_oil'];
              $registration_date = $_POST['registration_date'];
              $expiration_date = $_POST['expiration_date']; 
        
              if ($_GET['action'] === "add") {
                $query = "INSERT INTO vehicle
                (NAME, PLATE_NO, AVAILABILITY, DATE_BORROWED, start_change_oil, end_change_oil, registration_date, expiration_date)
                VALUES ('{$name}','{$plate_no}','1','{$date_borrowed}', '{$start_change_oil}', '{$end_change_oil}', '{$registration_date}', '{$expiration_date}')";
                mysqli_query($db,$query)or die ('Error in updating equipment in Database '.$query);
              }
            ?>
    <script type="text/javascript">
    window.location = "vehicle.php";
    </script>
</div>

<?php
include'../includes/footer.php';
?>