<?php
/*
Plugin Name: Pronouns
Plugin URI: https://my-awesomeness-emporium.com
Description: Adds a pronoun field for WordPress users
Version: 1.0
Author: Donny Chen
Author URI: https://donnychen.dev
License: GPL2
*/

require __DIR__ . '/Pronouns/vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'Pronouns') != false) {
        $namespace_path = str_replace("Plugins\\", "", $class_name);
        $file_path      = str_replace("\\", "/", $namespace_path);
        $file_name = stream_resolve_include_path($file_path . ".php");


        if ($file_name !== false) {
            include $file_name;
        }
    }
});


$initialize = new Plugins\Pronouns\Classes\Initialize();