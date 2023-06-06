<?php
include'../includes/connection.php';
include'../includes/sidebar.php';
            ?>
<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Vehicle Details</h4>
        </div>
        <a href="equipment.php?action=add" type="button" class="btn btn-primary bg-gradient-primary btn-block">
            <i class="fas fa-flip-horizontal fa-fw fa-share"></i> Back</a>
        <div class="card-body">
            <?php 
            $vId = $_GET['id'];
            date_default_timezone_set("Asia/Manila");
            $date = date("Y-m-d H:i:s");
            $query = "SELECT ID, NAME, PLATE_NO, AVAILABILITY, DATE_BORROWED, registration_date, expiration_date, start_change_oil, end_change_oil, TIMESTAMPDIFF(MONTH, '{$date}', expiration_date) as REGISTRATION, TIMESTAMPDIFF(MONTH, '{$date}', end_change_oil) as CHANGE_OIL FROM vehicle WHERE ID = '$vId'";
            $result = mysqli_query($db, $query) or die(mysqli_error($db));
              while($row = mysqli_fetch_array($result))
              {   
                $id = $row['ID'];
                $name= $row['NAME'];
                $plate_no= $row['PLATE_NO'];
                $availability= $row['AVAILABILITY'];
                $start_change_oil= $row['start_change_oil'];
                $end_change_oil= $row['end_change_oil'];
                $registration_date= $row['registration_date'];
                $expiration_date= $row['expiration_date'];
              }
          ?>

            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>
                        Vehicle ID<br>
                    </h5>
                </div>
                <div class="col-sm-9">
                    <h5>
                        : <?php echo $id; ?><br>
                    </h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>
                        Vehicle Name<br>
                    </h5>
                </div>
                <div class="col-sm-9">
                    <h5>
                        : <?php echo $name; ?> <br>
                    </h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>
                        Plate no: <br>
                    </h5>
                </div>
                <div class="col-sm-9">
                    <h5>
                        : <?php echo $plate_no; ?><br>
                    </h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>
                        Availability<br>
                    </h5>
                </div>
                <div class="col-sm-9">
                    <h5 style="color:green; font-weight: bold">
                        : <?php echo $availability === "1" ? "Available" : "Not available" ; ?><br>
                    </h5>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>
                        Registration Status<br>
                    </h5>
                </div>
                <div class="col-sm-9">
                <?php if (date("Y-m-d", strtotime($expiration_date)) < date("Y-m-d", strtotime(date("Y-m-d")))) :?>
                        <h5 style="color:red; font-weight: bold">
                        : <?php echo "Update Registration"; ?><br>
                        </h5>
                    <?php else: ?>
                        <h5 style="color:green; font-weight: bold">
                        : <?php echo "Registered" ; ?><br>
                        </h5>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>
                        Change Oil<br>
                    </h5>
                </div>
                <div class="col-sm-9">
                    <?php if (date("Y-m-d", strtotime($end_change_oil)) < date("Y-m-d", strtotime(date("Y-m-d")))) :?>
                        <h5 style="color:red; font-weight: bold">
                        : <?php echo "Oil Needs Changing"; ?><br>
                        </h5>
                    <?php else: ?>
                        <h5 style="color:green; font-weight: bold">
                        : <?php echo "Oil Changed" ; ?><br>
                        </h5>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>
                        Registration Dates<br>
                    </h5>
                </div>
                <div class="col-sm-9">
                    <h5>
                    Start - <?php
                        $registration_date = strtotime($registration_date);
                        $registration_date = date("Y/m/d", $registration_date); 
                        echo $registration_date; 
                        ?><br>
                    </h5>
                    <h5>
                    End - <?php 
                        $expiration_date = strtotime($expiration_date);
                        $expiration_date = date("Y/m/d", $expiration_date); 
                        echo $expiration_date;  
                        ?><br>
                    </h5>
                </div>
            </div>

            <div class="form-group row text-left">
                <div class="col-sm-3 text-primary">
                    <h5>
                        Change Oil<br>
                    </h5>
                </div>
                <div class="col-sm-9">
                <h5>
                    Start - <?php
                        $start_change_oil = strtotime($start_change_oil);
                        $start_change_oil = date("Y/m/d", $start_change_oil); 
                        echo $start_change_oil; 
                        ?><br>
                    </h5>
                    <h5>
                    End - <?php 
                        $end_change_oil = strtotime($end_change_oil);
                        $end_change_oil = date("Y/m/d", $end_change_oil); 
                        echo $end_change_oil;  
                        ?><br>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</center>


<?php
include'../includes/footer.php';
?>