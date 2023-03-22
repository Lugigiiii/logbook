<?php

function loadCar($array) {
    $html = '<select class="inp-fw" name="car" id="car-selector" type="text">';
    $html .= '<option value="" default>Fahrzeug...</option>';
    foreach ($array as $value) {
        $html .= "<option value='{$value}'>{$value}</option>";
    }
    $html .= '</select>';
    return $html;
}