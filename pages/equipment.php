<?php
include'../includes/connection.php';
include'../includes/sidebar.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Equipment&nbsp;
            <?php if ($_SESSION['TYPE'] === "User") :?>
            <?php else: ?>
            <a href="#" data-toggle="modal" data-target="#aModal" type="button"
                class="btn btn-primary bg-gradient-primary" style="border-radius: 0px;"><i
                    class="fas fa-fw fa-plus"></i></a>
            <?php endif; ?>
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Equipment Code</th>
                        <th>Name</th>
                        <th>Description/Condition</th>
                        <th>Quantity</th>
                        <th>Date Purchased</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php                  
    $query = 'SELECT * FROM equipment';
        $result = mysqli_query($db, $query) or die (mysqli_error($db));
      
            while ($row = mysqli_fetch_assoc($result)) {
                 ?>
                    <tr>
                        <td><?=$row['EQUIPMENT_ID']?></td>
                        <td><?=$row['NAME']?></td>
                        <td><?=$row['DESCRIPTION']?></td>
                        <td><?=$row['UNITS']?></td>
                        <td><?php 
                            $date = strtotime($row['DATE_PURCHASED']);
                            echo date("m/d/Y", $date);
                        ?></td>
                        <td><?=$row['TYPE']?></td>
                        <td align="right">
                            <div class="btn-group">
                                <a type="button" class="btn btn-primary bg-gradient-primary" href="eqs_searchfrm.php?action=edit&id=
                              <?= $row['EQUIPMENT_ID'] ?>"><i class="fas fa-fw fa-list-alt"></i> Details</a>

                                <?php if ($_SESSION['TYPE'] === "User") : ?>
                                <?php else: ?>
                                <div class="btn-group">
                                    <a type="button" class="btn btn-primary bg-gradient-primary dropdown no-arrow"
                                        data-toggle="dropdown" style="color:white;">
                                        <span class="caret"></span><i class="fas fa-fw fa-edit"></i></a>
                                    <ul class="dropdown-menu text-center" role="menu">
                                        <li>
                                            <a type="button" class="btn btn-warning bg-gradient-warning btn-block"
                                                style="border-radius: 0px;"
                                                href="eqs_edit.php?action=edit & id=<?=$row['EQUIPMENT_ID']?>">
                                                <i class="fas fa-fw fa-edit"></i> Edit
                                            </a>

                                        </li>
                                    </ul>
                                    <a type="button" class="btn btn-primary bg-gradient-primary"
                                    href="delete_equipment.php?id=<?=$row['EQUIPMENT_ID']?>">
                                    <i class="fas fa-fw fa-trash"></i> Delete</a>
                                </div>
                                <?php endif; ?>
                            </div>
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
include'../includes/footer.php';
?>

<div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Equipment</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="eqs_transac.php?action=add">
                    <div class="form-group">
                        <input class="form-control" placeholder="Name" name="NAME" required>
                    </div>
                    <div class="form-group">
                        <textarea rows="5" cols="50" texarea" class="form-control" placeholder="Description"
                            name="DESCRIPTION" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="number" min="1" max="999999999" class="form-control" placeholder="Quantity"
                            name="QTY_STOCK" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="number" placeholder="Price" name="price" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Unit ex. 10 kg" name="unit" required>
                    </div>
                    <div class="form-group">
                        <select name="TYPE" class="form-control">
                            <option selected disabled>SELECT</option>
                            <option value="Heavy Equipment">Heavy Equipment</option>
                            <option value="Light Equipment">Light Equipment</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control"
                            placeholder="Date Purchased" name="DATE_PURCHASED" required>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Save</button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Reset</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>