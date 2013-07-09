<?php
/**
 * Laraeval PHP Unit Loader.
 *
 * This file used to load all Laravel namespaces and classes so we don't have to download all
 * Laravel files inside our workbench.
 */
define('LARAVEL_BASE_PATH', realpath(dirname(__FILE__) . '/../../../'));

require LARAVEL_BASE_PATH . '/bootstrap/autoload.php';
require LARAVEL_BASE_PATH . '/bootstrap/start.php';
