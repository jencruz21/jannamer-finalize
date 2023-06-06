<?php
include'../includes/connection.php';
include'../includes/sidebar.php';

// JOB SELECT OPTION TAB
$sql = "SELECT DISTINCT JOB_TITLE, JOB_ID FROM job";
$result = mysqli_query($db, $sql) or die ("Bad SQL: $sql");

function dateFormat($date) {
    return date("Y-m-d", strtotime($date));
}

$opt = "<select class='form-control' name='jobs' required>
        <option value='' disabled selected>Select Role</option>";
  while ($row = mysqli_fetch_assoc($result)) {
    $opt .= "<option value='".$row['JOB_ID']."'>".$row['JOB_TITLE']."</option>";
  }

$opt .= "</select>";

        $query = 'SELECT ID, NAME, AVAILABILITY, PLATE_NO, DATE_BORROWED, registration_date, expiration_date, start_change_oil, end_change_oil FROM vehicle WHERE ID ='.$_GET['id'];
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        $row = mysqli_fetch_assoc($result);

        $id = $row['ID'];
        $name = $row['NAME'];
        $plate_no = $row['PLATE_NO'];
        $availability = $row['AVAILABILITY'];
        $date_borrowed = dateFormat($row['DATE_BORROWED']);
        $start_change_oil = dateFormat($row['start_change_oil']);
        $end_change_oil = dateFormat($row['end_change_oil']);
        $registration_date = dateFormat($row['registration_date']);
        $expiration_date = dateFormat($row['expiration_date']);
      ?>
<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Edit Vehicle</h4>
        </div><a type="button" class="btn btn-primary bg-gradient-primary btn-block" href="employee.php"> <i
                class="fas fa-flip-horizontal fa-fw fa-share"></i> Back </a>
        <div class="card-body">

            <form role="form" method="post" action="vehicle_edit1.php?id=<?= $id ?>">
                <input type="hidden" name="id" value="<?php echo $zz; ?>" />
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Name:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Name" name="name" value="<?php echo $name; ?>"
                            required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Plate Number:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" placeholder="Plate Number" name="plate_no"
                            value="<?php echo $plate_no; ?>" required>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Availability:
                    </div>
                    <div class="col-sm-9">
                        <div class="col">
                            <label for="availability" style="color: green">Available</label>
                            <input type="radio" name="availability" value="1"
                                <?php echo $availability === '1' ? "checked" : ""; ?>>
                        </div>
                        <div class="col">
                            <label for="availability" style="color: red">Not Available</label>
                            <input type="radio" name="availability" value="0"
                                <?php echo $availability === '0' ? "checked" : ""; ?>>
                        </div>
                    </div>
                </div>
                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Date borrowed:
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" type="date" placeholder="" name="date_borrowed"
                            value="<?php echo $date_borrowed; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Registration Date:
                    </div>
                    <div class="col-sm-9 mb-2">
                        <input class="form-control" input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Registration Date" name="registration_date"
                            value="<?php echo $registration_date; ?>" required>
                    </div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <input class="form-control" input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Expiration Date" name="expiration_date"
                            value="<?php echo $expiration_date; ?>" required>
                    </div>
                </div>

                <div class="form-group row text-left text-warning">
                    <div class="col-sm-3" style="padding-top: 5px;">
                        Change Oil:
                    </div>
                    <div class="col-sm-9 mb-2">
                        <input class="form-control" input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Start Change Oil" name="start_change_oil"
                            value="<?php echo $start_change_oil; ?>" required>
                    </div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 align-content-start">
                        <input class="form-control" input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="End Change Oil" name="end_change_oil"
                            value="<?php echo $end_change_oil; ?>" required>
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