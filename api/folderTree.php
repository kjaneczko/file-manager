<?php
require_once('../config.php');
require_once('classes/FilesManager.php');
$files_manager = new FilesManager(UPLOAD_DIR, true);
header('Access-Control-Allow-Origin: http://localhost:3000'); //replace * with the domain you want to be able to reach it.
header('Content-type:application/json;charset=utf-8');
header('Status: 200');
echo json_encode(['folderTree' => $files_manager->files_tree]);
exit();