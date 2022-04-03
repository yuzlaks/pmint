<?php

/*
|--------------------------------------------------------------------------
| Composer Autoloader
|--------------------------------------------------------------------------
|
| Load semua vendor composer, menggunakan include 'vendor/autoload.php'
| supaya project dapat ter-integrasi dengan vendor.
|
*/

require 'vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Initial .env 
|--------------------------------------------------------------------------
|
| Digunakan untuk mencetak daftar variabel lingkungan atau menjalankan 
| utilitas lain di lingkungan yang diubah tanpa harus mengubah lingkungan 
| yang ada saat ini.
|
| source : https://github.com/vlucas/phpdotenv
|
*/

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

/*
|--------------------------------------------------------------------------
| Dynamic URL
|--------------------------------------------------------------------------
|
| Dynamic Link adalah tautan dalam yang mengarah ke aplikasi yang berfungsi, 
| terlepas dari apakah pengguna telah memasang aplikasi atau belum.
|
*/

$base_url     = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https": "http");
$base_url    .= "://".@$_SERVER['HTTP_HOST'];
$base_url    .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$base_project = str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

/*
|--------------------------------------------------------------------------
| Library Package 
|--------------------------------------------------------------------------
|
| - Whoops : digunakkan untuk menghandler semua error untuk project anda.
|
| - Pixie : digunakkan untuk query builder pada project anda.

| - DelightAuth : digunakkan untuk integrasi auth.
| 
| - MiladRahimiRouter : digunakkan untuk integrasi routes pada project anda.
| 
*/

include 'app/Package/Whoops.php';
include 'app/Package/Pixie.php';
include 'app/Package/DelightAuth.php';
include 'app/Package/MiladRahimiRouter.php';