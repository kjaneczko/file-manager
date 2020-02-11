<?php
function merge_two_arrays($arr1, $arr2) {
    $arr = [];
    foreach($arr1 as $a1) {
        $arr[] = $a1;
    }
    foreach($arr2 as $a2) {
        $arr[] = $a2;
    }
    return $arr;
}