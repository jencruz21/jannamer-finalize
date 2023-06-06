<?php

function checkEquipmentStatus($status)
{
    $component = "";

    switch (strtolower($status)) {
        case 'brand new':
            # code...
            $component = "<h6 class='item-status font-weight-bold' style='color: green'>" . $status . "</h6>";
            break;
        case 'slightly used':
            # code...
            $component = "<h6 class='item-status font-weight-bold' style='color: #9ACD32'>" . $status . "</h6>";
            break;
        case 'used':
            # code...
            $component = "<h6 class='item-status font-weight-bold' style='color: yellow'>" . $status . "</h6>";
            break;
        case 'heavily used':
            # code...
            $component = "<h6 class='item-status font-weight-bold' style='color: orange'>" . $status . "</h6>";
            break;
        case 'damaged/maintenance':
            # code...
            $component = "<h6 class='item-status font-weight-bold' style='color: red'>" . $status . "</h6>";
            break;
        default:
            # code...
            break;
    }

    return $component;
}

function checkMaterialStatus($status)
{
    $component = "";

    switch (strtolower($status)) {
        case 'brand new':
            # code...
            $component = "<h6 class='item-status font-weight-bold' style='color: green'>" . $status . "</h6>";
            break;
        case 'consumed materials':
            # code...
            $component = "<h6 class='item-status font-weight-bold' style='color: red'>" . $status . "</h6>";
            break;
        case 'excess materials':
            # code...
            $component = "<h6 class='item-status font-weight-bold' style='color: yellow'>" . $status . "</h6>";
            break;
        default:
            # code...
            break;
    }

    return $component;
}

function toDate($toDate) {
    $toDate = strtotime($toDate);
    return date("Y-m-d", $toDate);
}