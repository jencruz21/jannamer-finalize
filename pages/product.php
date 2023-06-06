<?php
include'../includes/connection.php';
include'../includes/sidebar.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h4 class="m-2 font-weight-bold text-primary">Materials&nbsp;
            <?php if ($_SESSION['TYPE'] === "User") : ?>
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
                        <th>Product Code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php                  
    $query = 'SELECT PRODUCT_ID, PRODUCT_CODE, NAME, PRICE, QTY_STOCK, CNAME, DESCRIPTION, DATE_STOCK_IN FROM product p join category c on 
    p.CATEGORY_ID=c.CATEGORY_ID GROUP BY PRODUCT_CODE';
        $result = mysqli_query($db, $query) or die (mysqli_error($db));
      
            while ($row = mysqli_fetch_assoc($result)) {
     ?>
                    <tr>
                        <td><?= $row['PRODUCT_CODE'] ?></td>
                        <td><?= $row['NAME'] ?></td>
                        <td><?= $row['PRICE'] ?></td>
                        <td><?= $row['QTY_STOCK'] ?></td>
                        <td><?= $row['CNAME'] ?></td>
                        <td><?= $row['DESCRIPTION'] ?></td>
                        <td align="right">
                            <div class="btn-group">
                                <a type="button" class="btn btn-primary bg-gradient-primary"
                                    href="pro_searchfrm.php?action=edit & id=<?=$row['PRODUCT_CODE']?>">
                                    <i class="fas fa-fw fa-list-alt"></i> Details</a>
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
                                                href="pro_edit.php?action=edit & id=<?= $row['PRODUCT_ID'] ?>">
                                                <i class="fas fa-fw fa-edit"></i> Edit
                                            </a>
                                        </li>
                                    </ul>
                                    <a type="button" class="btn btn-primary bg-gradient-primary"
                                    href="delete_product.php?id=<?=$row['PRODUCT_ID']?>">
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

<!-- Product Modal-->
<div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Materials</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="pro_transac.php?action=add">
                    <div class="form-group">
                        <input class="form-control" placeholder="Material Code" name="prodcode" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Name" name="name" required>
                    </div>
                    <div class="form-group">
                        <textarea rows="5" cols="50" texarea" class="form-control" placeholder="Description"
                            name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="number" min="1" max="999999999" class="form-control" placeholder="Quantity"
                            name="quantity" required>
                    </div>
                    <div class="form-group">
                        <input type="number" min="1" max="9999999999" class="form-control" placeholder="Price"
                            name="price" required>
                    </div>
                    <div class="form-group">
                        <select name="category" class='form-control'>
                            <option disabled selected>SELECT CATEGORY</option>
                            <?php $result = mysqli_query($db, "SELECT * FROM category");?>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <option value="<?= $row['CATEGORY_ID'] ?>"><?= $row['CNAME']?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control"
                            placeholder="Date Stock In" name="datestock" required>
                    </div>
                    <hr>
                    <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i>Save</button>
                    <button type="reset" class="btn btn-danger"><i class="fa fa-times fa-fw"></i>Reset</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>