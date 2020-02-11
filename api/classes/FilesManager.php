<?php


class FilesManager
{
    protected $directory;
    public $files_tree;

    public function __construct($directory, $api = false) {
        $this->directory = $directory;
        $scandir = $this->scan_directory($this->directory);
        if($api) {

            $this->files_tree = $this->get_folder_tree($scandir, '/uploads');
        }
        else {
            $this->files_tree = "<ul>" . $this->display_folders_tree($scandir, '/uploads') . "</ul>";
        }

    }

    protected function scan_directory($directory) {
        $output = [];
        if(!is_dir($directory)) {
            return [];
        }
        $scandir = scandir($directory);
        foreach($scandir as $key => $dir) {
            if(!is_dir($directory) || !is_dir($directory.'/'.$dir) || in_array($dir, ['.', '..'])) {
                continue;
            }
            else {
                $output[$dir] = $this->scan_directory($directory.'/'.$dir);
            }
        }
        return $output;
    }

    protected function display_folders_tree($directory, $path) {
        $html = '';
        foreach($directory as $key => $dir) {
            $end_path = $path.'/'.$key;
            if(empty($dir)) {
                $html .= "<li><span data-dir='{$end_path}' onclick='change_dir(this)'>{$key}</span></li>";
            }
            else {
                $html .= "<li><span data-dir='{$end_path}' onclick='change_dir(this)'>{$key}</span> [+] <ul>" . $this->display_folders_tree($dir, $end_path) . "</ul></li>";
            }
        }
        return $html;
    }

    protected function get_folder_tree($directory, $path) {
        $output = [];

        foreach($directory as $key => $dir) {
            $end_path = $path.'/'.$key;
            if(empty($dir)) {
                $output[] = ['path' => $end_path, 'folder_name' => $key, 'subfolders' => []];
            }
            else {
                $output[] = ['path' => $end_path, 'folder_name' => $key, 'subfolders' => $this->get_folder_tree($dir, $end_path)];
            }
        }
        return $output;
    }
}