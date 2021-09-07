<?php
/**
 * Use this autoload (not composer autoload) 
 * if you want to developemnt this package
 */
spl_autoload_register(function($className) {
    $src_folder = dirname(__FILE__) . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR;
	$file = $src_folder . $className . '.php';
	if (file_exists($file)) {
		include_once $file;
	} else {
        throw new Exception("File [$file] not found");
    }
});