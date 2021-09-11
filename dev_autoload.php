<?php
/**
 * Use this autoload (not composer autoload)
 * if you want to developemnt this package
 */
spl_autoload_register(function($filename) {
    $src_folder = dirname(__FILE__) . "/src/";
	$file = $src_folder . str_replace("Tripay\\", "", $filename) . '.php';
	if (file_exists($file)) {
		include_once $file;
	} else {
        throw new Exception("File [$file] not found");
    }
});
