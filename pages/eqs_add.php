<?php
include'../includes/connection.php';
include'../includes/sidebar.php';
?>

          <center><div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
            <div class="card-header py-3">
              <h4 class="m-2 font-weight-bold text-primary">Add Equipment</h4>
            </div>
            <a href="product.php?action=add" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
            <div class="card-body">
                      <div class="table-responsive">



                        <form role="form" method="post" action="eqs_transac.php?action=add">
                            <div class="form-group">
                              <input class="form-control" placeholder="Equipment Code" name="EQUIPMENT_CODE" required>
                            </div>
                            <div class="form-group">
                              <input class="form-control" placeholder="Name" name="EQUIPMENT_NAME" required>
                            </div>
                            <div class="form-group">
                              <textarea rows="5" cols="50" texarea" class="form-control" placeholder="Description" name="EQDESCRIPTION" required></textarea>
                            </div>
                            <div class="form-group">
                              <input type="number"  min="1" max="999999999" class="form-control" placeholder="Quantity" name="EQQTY" required>
                            </div>
                            <div class="form-group">
                              <select name="TYPE" id=""></select>
                            </div>
                            <div class="form-group">
                              <input type="datet" class="form-control" placeholder="Date Stock In" name="DATE_PURCHASED" required>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-check fa-fw"></i>Save</button>
                            <button type="reset" class="btn btn-danger btn-block"><i class="fa fa-times fa-fw"></i>Reset</button>
                            
                        </form>  







                      </div>
            </div>
          </div></center>
        
<?php
include '../includes/footer.php';
?>
