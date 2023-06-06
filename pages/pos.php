<?php
include '../includes/connection.php';
include '../includes/topp.php';
include '../includes/helper.php';
?>

<div class="row">
    <div class="col-lg-6">
        <div class="rounded shadow p-3" style="background-color: white;">
            <h1 class="text-center my-4">Transaction Process</h1>
            <form class="form">
                <div class="row row-cols-2">
                    <div class="col">
                        <div class="form-group">
                            <input class="form-control" type="text" readonly placeholder="₱ 0" id="total_cost">
                        </div>
                        <div class="form-group">
                        <select class="form-control" name="user" id="user_id">
                        <?php
$result = mysqli_query($db, "SELECT * FROM employee");
?>                          <option selected disabled>Select employee name</option>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <option value="<?=$row['EMPLOYEE_ID']?>"><?=$row['FIRST_NAME'] . " " . $row["LAST_NAME"]?></option>
                            <?php endwhile;?>
                        </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <button id="proceed" class="btn btn-primary w-100">CHECKOUT</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary w-100" id="reset">Reset</button>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-2">
                    <div class="col">
                        <div class="form-group">
                            <input class="form-control" type="number" name="amount_paid" id="amount_paid"
                                placeholder="Enter amount">
                        </div>
                        <div class="form-group">
                            <?php
$result = mysqli_query($db, "SELECT * FROM vehicle WHERE AVAILABILITY = 1");
?>
                            <select id="vehicle" class="form-control">
                                <option>SELECT A VEHICLE</option>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <?php if (
                                        (date("Y-m-d", strtotime($row["end_change_oil"])) < date("Y-m-d", strtotime(date("Y-m-d"))))
                                        ||
                                        (date("Y-m-d", strtotime($row["expiration_date"])) < date("Y-m-d", strtotime(date("Y-m-d"))))
                                    ) : ?>
                                    <?php else : ?>
                                        <option value="<?=$row['ID']?>"><?=$row['NAME']?></option>
                                    <?php endif; ?>
                                <?php endwhile;?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <textarea class="form-control" name="" cols="20" rows="5" placeholder="Enter details"
                                id="details"></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th width="40%">Name</th>
                        <th width="10%">Unit</th>
                        <th width="10%">Price</th>
                        <th width="10%">Type</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <!-- table content -->
                <tbody id="table">

                </tbody>
                <!-- <tr class="remove-item">
                    <td>Wilcons Product</td>
                    <td>25</td>
                    <td>300</td>
                    <td>Heavy Equipment</td>
                    <td>
                        <button class="btn btn-danger delete-button">
                            <i class="fas fa-fw fa-trash"></i>
                        </button>
                    </td>
                </tr> -->
            </table>
        </div>
    </div>
    <div class="col-lg-6">

        <h3>Equipments</h3>
        <div class="d-flex flex-wrap">
            <?php
$result = mysqli_query($db, "SELECT * FROM equipment WHERE QTY_STOCK > 0 AND status != 'Damaged/Maintenance'");
?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="col-sm-6 col-md-4 mb-3 search-item">
                <div class="products item">
                    <h6 class="text-info item-name"><?php echo $row['NAME']?><span class="item-class" style="visibility: hidden">E</span></h6>
                    <h6 class="item-unit"><?php echo $row['UNITS']?></h6>
                    <h6 class="item-type"><?php echo $row['TYPE']?></h6>
                    <?php if ($row['item_class'] === "M") : ?>
                        <?php echo checkMaterialStatus($row['status']); ?>
                    <?php else : ?>
                        <?php echo checkEquipmentStatus($row['status']); ?>
                    <?php endif;?>
                    <h6 class="item-id" style="visibility: hidden;"><?php echo $row['EQUIPMENT_ID']?>
                    </h6>
                    <h6 class="text-right item-price">₱ <?php echo $row['PRICE']?></h6>
                </div>
            </div>
            <?php endwhile; ?>

        </div>

        <h3>Materials</h3>
        <div class="d-flex flex-wrap">
            <?php
$result = mysqli_query($db, "SELECT p.*, c.CNAME FROM product p INNER JOIN category c ON p.CATEGORY_ID = c.CATEGORY_ID WHERE QTY_STOCK > 0");
?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="col-sm-6 col-md-4 mb-3 search-item">
                <div class="products item">
                    <h6 class="text-info item-name"><?php echo $row['NAME']?><span class="item-class" style="visibility: hidden">M</span></h6>
                    <h6 class="item-unit"><?php echo $row['DESCRIPTION']?></h6>
                    <h6 class="item-type"><?php echo $row['CNAME']?></h6>
                    <h6 class="item-status font-weight-bold" style="color: green">Brand New</h6>
                    <h6 class="item-id" style="visibility:hidden"><?php echo $row['PRODUCT_ID']?>
                    </h6>
                    <h6 class="text-right item-price">₱ <?php echo $row['PRICE']?></h6>
                </div>
            </div>
            <?php endwhile; ?>

        </div>
    </div>
</div>

<!-- POS SYSTEM JS -->
<script>
// FUTURE GOALS
// this needs to be re written to store data in local storage para atleast may persistence
const item = document.getElementsByClassName('item');
const table = document.getElementById('table');
const itemRemoval = document.getElementsByClassName('remove-item');

//checkout items
const proceed = document.getElementById('proceed'); //button
// eto ung total cost component
const totalCostComponent = document.getElementById('total_cost');
const amountPaidComponent = document.getElementById('amount_paid');
const detailsComponent = document.getElementById('details');
const vehicleComponent = document.getElementById('vehicle');
// const userComponent = document.getElementById('user');
const userIdComponent = document.getElementById('user_id');
const userPositionComponent = document.getElementById('user_position');
const reset = document.getElementById('reset');
let tr = null;

//search components
const search = document.getElementById("search");
const searchItems = document.getElementsByClassName("search-item");

let uuid = generateUUID();

// strings
let totalCost = "";
let amountPaid = 0;
let details = "";
let vehicle = "";

// other states for totalling
let totalPrice = 0;
let numOfItems = 0;
// data to submit in rest api
let data = [];

for (let i = 0; i < item.length; i++) {
    item[i].addEventListener("click", function(e) {
        const itemName = item[i].getElementsByClassName('item-name')[0].innerText;
        const unit = item[i].getElementsByClassName('item-unit')[0].innerText;
        const type = item[i].getElementsByClassName('item-type')[0].innerText;
        const itemId = item[i].getElementsByClassName('item-id')[0].innerHTML;
        const status = item[i].getElementsByClassName('item-status')[0].innerText;
        const price = item[i].getElementsByClassName('item-price')[0].innerText;
        const itemClass = item[i].getElementsByClassName('item-class')[0].innerHTML;
        const finalPrice = parseInt(price.substring(2));

        // console.log("item name: " + itemName);
        // console.log("item unit: " + unit);
        // console.log("item type: " + type);
        // console.log("item itemId: " + itemId);
        // console.log("item status: " + status);
        // console.log("item price: " + price);
        // console.log("final Price: " + finalPrice);

        totalPrice += finalPrice;
        totalCostComponent.value = "₱ " + totalPrice;
        numOfItems++;


        tr = document.createElement('tr');
        tr.className = 'remove-item';
        const td1 = document.createElement('td');
        const td2 = document.createElement('td');
        const td3 = document.createElement('td');
        const td4 = document.createElement('td');
        const td5 = document.createElement('td');
        const ico = document.createElement("i");
        const btn = document.createElement('span');
        btn.className = "btn btn-danger delete-button";
        ico.className = "fas fa-fw fa-trash";
        btn.appendChild(ico);
        td5.appendChild(btn);

        data.push({
            itemName,
            unit,
            price: finalPrice,
            type,
            itemId,
            status,
            checkOutId: uuid,
            itemClass
        });

        td1.innerHTML = itemName;
        td2.innerHTML = unit;
        td3.innerHTML = price;
        td4.innerHTML = type;

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5)

        table.appendChild(tr);

        for (let j = 0; j < itemRemoval.length; j++) {
            itemRemoval[j].getElementsByTagName('td')[4].addEventListener('click', function(e) {
                e.target.addEventListener('click', function() {
                    // Fetch Price
                    const equipmentPrice = itemRemoval[j].getElementsByTagName('td')[2]
                        .innerText;
                    const equipmentPriceStr = equipmentPrice.substring(2);
                    totalPrice -= equipmentPriceStr;
                    totalCostComponent.value = "₱ " + totalPrice;

                    // Fetch name 
                    const equipmentName = itemRemoval[j].getElementsByTagName('td')[0]
                        .innerText;
                    const index = data.map(data => data.itemName).indexOf(equipmentName);
                        
                    if (index > -1) {
                        data.splice(index, 1);
                        numOfItems -= 1;
                        // if (data.length <= 1) {
                        //     j = 0;
                        // } else {
                        //     document.getElementsByClassName('remove-item')[j].innerHTML = "";
                        // }
                        document.getElementsByClassName('remove-item')[j].innerHTML = "";
                    }
                });
            }); 
        }
    });
}

amountPaidComponent.addEventListener('change', function(e) {
    amountPaid = e.target.value;
});

detailsComponent.addEventListener('change', function(e) {
    details = e.target.value;
});

vehicleComponent.addEventListener('change', function(e) {
    vehicle = e.target.value;
});

reset.addEventListener('click', function() {
    for (let i = 0; i < data.length; i++) {
        data.shift();
    }

    table.innerHTML = "";
    cleanUp();
})

proceed.addEventListener('click', function(e) {
    e.preventDefault();
    if (parseInt(amountPaid) < parseInt(totalPrice)) {
        alert("The amount you paid is insufficient!\nTotal amount: " + amountPaid);
        exit();
    } else if (parseInt(amountPaid) === 0) {
        alert("The amount you paid is insufficient!");
    } else {
        // details          ✅
        // total items      ✅
        // total cost       ✅
        // amount paid      ✅
        // vehicle id       ✅
        // employee id      ✅
        // checkout date    ✅
        // checkout id      ✅
        // console.log("Employee Id: " + userIdComponent.value);
        // console.log("total_cost: " + totalPrice);
        // console.log("total_item_count: " + numOfItems);
        // console.log("amount_paid: " + amountPaid);
        // console.log("detail: " + details);
        // console.log("vehicle_id: " + vehicle);
        // console.log("checkout_id: " + uuid);

        const checkoutBody = new URLSearchParams();

        checkoutBody.append('employee_id', userIdComponent.value)
        checkoutBody.append("total_cost", totalPrice);
        checkoutBody.append("total_item_count", numOfItems);
        checkoutBody.append('amount_paid', amountPaid);
        checkoutBody.append('detail', details);
        checkoutBody.append('vehicle_id', vehicle);
        checkoutBody.append('checkout_id', uuid);

        fetch('../api/checkout.php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: checkoutBody
            })
            .then(res => {
                return res.text();
            })
            .then(result => {
                console.log(result);
                cleanUp();
            })
            .catch(err => console.error(err));
            console.log("Test End");
            
        for (let i = 0; i < data.length; i++) {
            const checkoutItem = new URLSearchParams();
            checkoutItem.append('name', data[i].itemName);
            checkoutItem.append('qty', 1);
            checkoutItem.append('unit', data[i].unit);
            checkoutItem.append('type', data[i].type);
            checkoutItem.append('price', data[i].price);
            checkoutItem.append('status', data[i].status);
            checkoutItem.append('item_id', data[i].itemId);
            checkoutItem.append('chkout_id', uuid);
            checkoutItem.append('item_class', data[i].itemClass);

            setTimeout(function() {
                fetch('../api/checkout_items.php', {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: checkoutItem
                    })
                    .then(res => res.text())
                    .then(result => {
                        data.shift();
                        console.log(result)
                    })
                    .catch(e => console.error(e));
                    
            }, 500);
        }
        table.innerHTML = "";
    }

    uuid = generateUUID();
});

//clean up function dito
function cleanUp() {
    amountPaid = 0;
    totalCost = "";
    details = "";
    vehicle = "";

    amountPaidComponent.value = "";
    totalCostComponent.value = "";
    detailsComponent.value = "";
    vehicleComponent.value = "SELECT A VEHICLE";
}

function generateUUID() {
    var d = new Date().getTime(); //Timestamp
    var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now() * 1000)) ||
        0; //Time in microseconds since page-load or 0 if unsupported
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16; //random number between 0 and 16
        if (d > 0) { //Use timestamp until depleted
            r = (d + r) % 16 | 0;
            d = Math.floor(d / 16);
        } else { //Use microseconds since page-load if supported
            r = (d2 + r) % 16 | 0;
            d2 = Math.floor(d2 / 16);
        }
        return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
}

search.addEventListener("keyup", function(e) {
    const searchValue = e.target.value.toLowerCase();
    
    for (let i = 0; i < searchItems.length; i++) {
    const itemName = searchItems[i].getElementsByClassName("item")[0].getElementsByTagName("h6")[0];
    let textValue = itemName.innerText || itemName.textContent;

    if (textValue.toLowerCase().indexOf(searchValue) > -1) {
        searchItems[i].style.display = "";
    } else {
        searchItems[i].style.display = "none";
    }
}
});
</script>

<?php
include '../includes/footer.php';
?>