<?php
function sort_array_by_file_name($arr) {
    usort($arr, function($a, $b) {
        return strcasecmp($a['text'], $b['text']);
    });
    return $arr;
}