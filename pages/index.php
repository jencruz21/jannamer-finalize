<?php
include '../includes/connection.php';
include '../includes/sidebar.php';
?>
<div class="row show-grid">
    <div class="col-md-3">
        <div class="col-md-12 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Employees</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?php
$query = "SELECT COUNT(*) FROM employee";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_array($result)) {
    echo "$row[0]";
}
?> Record(s)
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- User record -->
    </div>

    <div class="col-md-3">
        <div class="col-md-12 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Registered Account
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <?php
$query = "SELECT COUNT(*) FROM users WHERE TYPE_ID=2";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_array($result)) {
    echo "$row[0]";
}
?> Record(s)
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="col-md-12 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Materials</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                                        <?php
$query = "SELECT COUNT(*) FROM product";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_array($result)) {
    echo "$row[0]";
}
?> Record(s)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <!-- Product record -->
        <div class="col-md-12 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">

                        <div class="col mr-0">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Equipment</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                                        <?php
$query = "SELECT COUNT(*) FROM product";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_array($result)) {
    echo "$row[0]";
}
?> Record(s)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-gray-300"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col">
    <div class="card shadow h-100">
        <div class="card-body">
            <!-- <div class="row no-gutters align-items-center">

            </div> -->
            <div class="col mb-2">
                <i class="fa fa-th-list fa-fw"></i>
                <span class="panel-heading"> Recent Added
                </span>
            </div>

            <div class="row row-cols-2">

                <div class="col">
                    <div class="h6 mb-0 mr-0 text-gray-800">

                        <div class="panel-body">
                        <a href="product.php" class="btn btn-default btn-block font-weight-bold">View All Materials</a>
                            <div class="list-group">
                                <?php
$query = "SELECT NAME, PRODUCT_CODE FROM product order by PRODUCT_ID DESC LIMIT 10";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_array($result)) {

    echo "<a href='#' class='list-group-item text-gray-800'>
                                          <i class='fa fa-tasks fa-fw'></i> $row[0]
                                          </a>";
}
?>
                            </div>
                        </div>

                        <!-- /.panel-body -->
                    </div>
                    <!-- <div class="row no-gutters align-items-center mt-1">
                    </div> -->
                </div>

                <div class="col">
                    <div class="h6 mb-0 mr-0 text-gray-800">
                        <div class="panel-body">
                        <a href="equipment.php" class="btn btn-default btn-block font-weight-bold">View All Equipment</a>
                            <div class="list-group">
                                <?php
$query = "SELECT NAME, TYPE FROM equipment order by EQUIPMENT_ID DESC LIMIT 10";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
while ($row = mysqli_fetch_array($result)) {

    echo "<a href='#' class='list-group-item text-gray-800'>
                                          <i class='fa fa-tasks fa-fw'></i> $row[0]
                                          </a>";
}
?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</div>

</div>

<?php
include '../includes/footer.php';
?>