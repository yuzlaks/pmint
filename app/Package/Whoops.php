<?php

// source : https://github.com/filp/whoops

if ($_ENV['DEBUG'] == "TRUE") {

    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
    
}else{

    error_reporting(0);
    ini_set('display_errors', 0);
    
}