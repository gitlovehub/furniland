<?php

// Khai báo các hàm dùng Global
if (!function_exists('require_file')) {
    function require_file($pathFolder) {
        $files = array_diff(scandir($pathFolder), ['.', '..']);

        foreach ($files as $item) {
            require_once $pathFolder . $item;
        }
    }
}

if (!function_exists('debug')) {
    function debug($data) {
        echo "<pre>";
        print_r($data);
        die;
    }
}

if (!function_exists('page404')) {
    function page404() {
        echo "<h2>Page Not Found :(</h2>";
        echo "<h4>Oops! 😖 The requested URL was not found on this server.</h4>";
        die;
    }
}