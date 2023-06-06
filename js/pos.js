const item = document.getElementsByClassName('item');
    const table = document.getElementById('table');
    const itemRemoval = document.getElementsByClassName('remove-item');

    //checkout items
    const proceed = document.getElementById('proceed'); //button
    const totalCostComponent = document.getElementById('total_cost');
    const amountPaidComponent = document.getElementById('amount_paid');
    const detailsComponent = document.getElementById('details');
    const vehicleComponent = document.getElementById('vehicle');
    const userComponent = document.getElementById('user');
    const userIdComponent = document.getElementById('user_id');
    const userPositionComponent = document.getElementById('user_position');
    let tr = null;

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
            const itemId = item[i].getElementsByClassName('item-id')[0].innerText;
            const status = item[i].getElementsByClassName('item-status')[0].innerText;
            const price = item[i].getElementsByClassName('item-price')[0].innerText;
            const finalPrice = parseInt(price.substring(2));
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
                checkOutId: uuid
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
                        const equipmentName = itemRemoval[j].getElementsByTagName('td')[0].innerText;
                        const index = data.map(data => data.itemName).indexOf(equipmentName);
                        if (index > -1) {
                            data.splice(index, 1);
                        }
                        document.getElementsByClassName('remove-item')[j].style="display: none"
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

    proceed.addEventListener('click', function(e) {
        if (parseInt(amountPaid) < parseInt(totalPrice)) {
            alert("The amount you paid is insufficient!\nTotal amount: " + amountPaid);
            exit();
        } else if (parseInt(amountPaid) === 0) {
            alert("The amount you paid is insufficient!");
        } else {
            const checkoutBody = new URLSearchParams();

            checkoutBody.append('user', userComponent.value);
            checkoutBody.append('user_id', userIdComponent.value)
            checkoutBody.append('user_position', userPositionComponent.value);
            checkoutBody.append("total_cost", totalPrice);
            checkoutBody.append("total_item_count", numOfItems);
            checkoutBody.append('amount_paid', amountPaid);
            checkoutBody.append('detail', details);
            checkoutBody.append('vehicle', vehicle);
            checkoutBody.append('checkout_id', uuid);

            fetch('../api/checkout.php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: checkoutBody
            })
            .then(res =>
                res.text())
            .then(result => {
                console.log(result);
                cleanUp();
            })
            .catch(err => console.error(err));

            for (let i = 0; i < data.length; i++) {
                const checkoutItem = new URLSearchParams();
                checkoutItem.append('name', data[i].itemName);
                checkoutItem.append('qty', 1);
                checkoutItem.append('unit', data[i].unit);
                checkoutItem.append('type', data[i].type);
                checkoutItem.append('price', data[i].price);
                checkoutItem.append('status', data[i].status);
                checkoutItem.append('chkout_id', uuid);
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
                    table.firstChild.remove();
                }, 500);
            }
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
        var d = new Date().getTime();//Timestamp
        var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now()*1000)) || 0;    //Time in microseconds since page-load or 0 if unsupported
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16;     //random number between 0 and 16
            if(d > 0){      //Use timestamp until depleted
                r = (d + r)%16 | 0;
                d = Math.floor(d/16);
            } else {    //Use microseconds since page-load if supported
                r = (d2 + r)%16 | 0;
                d2 = Math.floor(d2/16);
            }
            return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });
    }