<?php
/**
 * Laraeval PHP Unit Loader.
 *
 * This file used to load all Laravel namespaces and classes so we don't have to download all
 * Laravel files inside our workbench.
 */
define('LARAVEL_BASE_PATH', realpath(dirname(__FILE__) . '/../../../'));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require LARAVEL_BASE_PATH . '/bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let's turn on the lights.
| This bootstrap the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight these users.
|
*/

$app = require LARAVEL_BASE_PATH . '/bootstrap/start.php';

/*
|--------------------------------------------------------------------------
| Boot the App
|--------------------------------------------------------------------------
|
| We just need to boot the up and all the namespaces and classes will be
| loaded automatically. No need to run the app.
|
*/

$app->boot();
