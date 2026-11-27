<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('html_errors', '0');
register_shutdown_function(function () {
    $e = error_get_last();
    if ($e) {
        echo "\n\n=== SHUTDOWN ERROR ===\n";
        print_r($e);
    }
});
echo "DIAG START\n";
echo "PHP " . PHP_VERSION . "\n";
echo "CWD " . getcwd() . "\n";
echo "HOST " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '(none)') . "\n";
include "index.php";
echo "\nDIAG END\n";
