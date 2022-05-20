<?php

spl_autoload_register(function ($class) {
    $dirs = ['components', 'controllers', 'models'];
    foreach ($dirs as $dir) {
        $fileName = "$dir/" . mb_strtolower($class) . ".php";
        if (file_exists($fileName)) {
            require_once($fileName);
        }
    }
});
