<?php
include'../includes/connection.php';
include'../includes/sidebar.php';
?>
            
            <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Vehicle&nbsp;<a  href="#" data-toggle="modal" data-target="#aModal" 
              type="button" class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i class="fas fa-fw fa-plus"></i></a></h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0"> 
               <thead>
                   <tr>
                     <th>Name</th>
                     <th>Plate Number</th>
                     <th>Availability</th>
                     <th>Date Purchased</th>
                     <th>Registration Status</th>
                     <th>Change Oil Status</th>
                     <th>Action</th>
                   </tr>
               </thead>
          <tbody>

<?php                  
    date_default_timezone_set("Asia/Manila");
    $date = date("Y-m-d H:i:s");
    $query = "SELECT ID, NAME, PLATE_NO, AVAILABILITY, DATE_BORROWED, expiration_date, end_change_oil FROM vehicle";
    // SELECT TIMESTAMPDIFF(MONTH, "2022-01-01", "2022-02-01");
        $result = mysqli_query($db, $query) or die (mysqli_error($db));
      
            while ($row = mysqli_fetch_assoc($result)) {
                $availability = $row['AVAILABILITY'] === "0" ? '<img src="../img/red-cross.png" width="25" height="25" alt="Available">' : '<img src="../img/approved.jpg" width="25" height="25" alt="Available">'; 
                $registration = date("Y-m-d", strtotime($row["expiration_date"])) < date("Y-m-d", strtotime(date("Y-m-d"))) ? "<span class='font-weight-bold' style='color: red'>Update Registration</span>" : "<span class='font-weight-bold' style='color: green'>Registered</span>";
                $changeOil = date("Y-m-d", strtotime($row["end_change_oil"])) < date("Y-m-d", strtotime(date("Y-m-d"))) ? "<span class='font-weight-bold' style='color: red'>Oil Needs Changing</span>" : "<span class='font-weight-bold' style='color: green'>Oil Changed</span>";                
                echo '<tr>';
                echo '<td>'. $row['NAME'].'</td>';
                echo '<td>'. $row['PLATE_NO'].'</td>';
                echo '<td>'. $availability .' </td>';
                echo '<td>'. date("m/d/Y", strtotime($row['DATE_BORROWED'])).'</td>';
                echo '<td>'. $registration .' </td>';
                echo '<td>'. $changeOil .' </td>';
                      echo '<td align="right"> <div class="btn-group">
                              <a type="button" class="btn btn-primary bg-gradient-primary" href="vehicle_searchfrm.php?action=edit & id='
                              .$row['ID'] . '"><i class="fas fa-fw fa-list-alt"></i> Details</a>
                            <div class="btn-group">
                              <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow" data-toggle="dropdown" style="color:white;">
                              <span class="caret"></span><i class="fas fa-fw fa-edit"></i></a>
                            <ul class="dropdown-menu text-center" role="menu">
                                <li>
                                  <a type="button" class="btn btn-warning bg-gradient-warning btn-block" style="border-radius: 0px;" 
                                  href="vehicle_edit.php?action=edit & id='.$row['ID']. '">
                                    <i class="fas fa-fw fa-edit"></i> Edit
                                  </a>
                                </li>
                            </ul>
                            <a type="button" class="btn btn-primary bg-gradient-primary"
                                    href="delete_vehicle.php?id=' . $row['ID'] . '">
                                    <i class="fas fa-fw fa-trash"></i> Delete</a>
                            </div>
                          </div> </td>';
                echo '</tr> ';
                        }
?> 
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>

<?php
include'../includes/footer.php';
?>

  <div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Vehicle</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="vehicle_transac.php?action=add">
           <div class="form-group">
             <input class="form-control" placeholder="Vehicle Name" name="Name" required>
           </div>
           <div class="form-group">
             <input class="form-control" placeholder="Plate Number" name="PlateNo" required>
           </div>
           <div class="form-group mb-2">
             <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" 
             placeholder="Date Borrowed" name="date_borrowed" required>
           </div>
           <div class="form-group mb-2">
           <label class="form-label font-weight-bold" for="start_change_oil">Change Oil</label>
             <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control mb-1" 
             placeholder="Starting Date (Change Oil)" name="start_change_oil" required>
             <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" 
             placeholder="Expiration Date (Change Oil)" name="end_change_oil" required>
           </div>
           <div class="form-group mb-2">
            <label class="form-label font-weight-bold" for="start_registration">Registration</label>
             <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control mb-1" 
             placeholder="Registration Date" name="registration_date" required>
             <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" 
             placeholder="Expiration Date" name="expiration_date" required>
           </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Save</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>      
          </form>  
        </div>
      </div>
    </div>
  </div>