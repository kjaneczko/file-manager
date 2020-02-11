<?php
require_once('../config.php');
require_once('helpers/array/sort.php');
require_once('helpers/array/merge.php');
$ds = DIRECTORY_SEPARATOR;
$requested_dir = isset($_REQUEST['folderDir']) ? str_replace(['.'.$ds, '..'.$ds, $ds.'.', $ds.'..'],'', $_REQUEST['folderDir']) : '';
$requested_dir = trim($requested_dir, $ds);
$real_path = realpath(PUBLIC_DIR.$ds.$requested_dir);
$exploded_path = explode($ds, $requested_dir);
$path_validated = false;
if($exploded_path[0] === 'uploads') {
    $path_validated = true;
}
$output = [];
if($path_validated && is_dir($real_path)) {
    $scandir = scandir($real_path);
    if(count($exploded_path) > 1) {
        array_pop($exploded_path);
    }
    $previous_dir = implode($ds, $exploded_path);
    $output_dirs[] = [
        'type' => 'dir',
        'text' => '..',
        'attributes' => [
            'data-dir' => $previous_dir,
        ],
    ];
    $output_files = [];
    $html = '';
    foreach($scandir as $key => $file_or_dir) {
        if(!in_array($file_or_dir, ['.', '..'])) {
            $dir = $real_path.$ds.$file_or_dir;
            $d = $requested_dir.$ds.$file_or_dir;
            if(is_dir($dir)) {
                $output_dirs[] = [
                    'type' => 'dir',
                    'text' => $file_or_dir,
                    'attributes' => [
                        'data-dir' => $d,
                        'onclick' => 'change_dir(this)',
                    ],
                ];
            }
            else {
                $output_files[] = [
                    'type' => 'file',
                    'text' => $file_or_dir,
                    'attributes' => [
                        'href' => $d,
                    ],
                ];
            }
        }
    }
    $output_dirs = sort_array_by_file_name($output_dirs);
    $output_files = sort_array_by_file_name($output_files);
    $output = merge_two_arrays($output_dirs, $output_files);
}
header('Access-Control-Allow-Origin: http://localhost:3000'); //replace * with the domain you want to be able to reach it.
header('Content-type:application/json;charset=utf-8');
header('Status: 200');
echo json_encode(['folderContent' => $output]);
exit();