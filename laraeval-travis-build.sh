#!/bin/bash
######################################################################
# Laraeval Travis Build Script
#
# (c) Rio Astamal <me@rioastamal.net>
# License: MIT
######################################################################
#
BASE_DIR=`pwd`
BUILD_DIR=${BASE_DIR}/laraeval-travis-build
LARAVEL_FILE=${BUILD_DIR}/laravel-app.tar.bz2
LARAVEL_APP_DIR=${BUILD_DIR}/laravel-app
COMPOSER_PATH=${BUILD_DIR}/composer.json
PHPUNIT_CONFIG_PATH=${BUILD_DIR}/phpunit.xml
PHPUNIT_LOADER_PATH=${BUILD_DIR}/phpunit_loader.php

# Composer is slow... so I don't want Travis-CI.org to redownload all the
# laravel related packages everytime build process spawn.
LARAVEL_APP_URL='https://dl.dropboxusercontent.com/u/4674107/laraeval/laravel-app.tar.bz2'

mkdir -p $BUILD_DIR

# cd to the laravel app
cd ${BUILD_DIR}

# download our laravel app
if [ ! -f ${LARAVEL_FILE} ]; then
    echo -n "[LARAEVAL] Downloading Laravel Framework..."
    wget ${LARAVEL_APP_URL} -O ${LARAVEL_FILE}
    echo "done."
else
    echo "[LARAEVAL BUILD NOTICE] File ${LARAVEL_FILE} already exists."
fi

echo -n "[LARAEVAL] Extracting Laravel Framework..."
tar -jxf ${LARAVEL_FILE} -C ./
echo "done."

# write phpunit xml config
echo -n "[LARAEVAL] Writing phpunit xml config file..."
cat <<XML > ${PHPUNIT_CONFIG_PATH}
<?xml version="1.0" encoding="UTF-8"?>
<phpunit backupGlobals="false"
         backupStaticAttributes="false"
         bootstrap="phpunit_loader.php"
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false"
         syntaxCheck="false"
>
    <testsuites>
        <testsuite name="Package Test Suite">
            <directory suffix=".php">${BASE_DIR}/tests/</directory>
        </testsuite>
    </testsuites>
</phpunit>
XML
echo "done."

# write PHP script to load all Laravel classes and namespaces
echo -n "[LARAEVAL] Writing Laraeval auto loader for phpunit..."
cat <<AUTO > ${PHPUNIT_LOADER_PATH}
<?php
/**
 * Laraeval PHP Unit Loader.
 *
 * This file used to load all Laravel namespaces and classes so we don't have to download all
 * Laravel files inside our workbench.
 */
define('LARAVEL_BASE_PATH', '${LARAVEL_APP_DIR}');

require LARAVEL_BASE_PATH . '/bootstrap/autoload.php';
require LARAVEL_BASE_PATH . '/../../src/Laraeval/Laraeval/LaraevalServiceProvider.php';
require LARAVEL_BASE_PATH . '/../../src/Laraeval/Laraeval/Laraeval.php';

\$app = new Illuminate\Foundation\Application;
\$env = \$app->detectEnvironment(array(

	'local' => array('your-machine-name'),

));
\$app->bindInstallPaths(require LARAVEL_BASE_PATH.'/bootstrap/paths.php');

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Config\Repository as Config;

\$app->instance('app', \$app);

\$app['env'] = 'testing';
Facade::clearResolvedInstances();
Facade::setFacadeApplication(\$app);

\$config = new Config(\$app->getConfigLoader(), \$env);

\$app->instance('config', \$config);

\$app->startExceptionHandling();

if (\$env != 'testing') ini_set('display_errors', 'Off');

if (\$app->runningInConsole())
{
	\$app->setRequestForConsoleEnvironment();
}

\$config = \$app['config']['app'];

date_default_timezone_set(\$config['timezone']);

AliasLoader::getInstance(\$config['aliases'])->register();
Request::enableHttpMethodParameterOverride();

\$providers = \$config['providers'];
\$providers[] = 'Laraeval\Laraeval\LaraevalServiceProvider';

\$app->getProviderRepository()->load(\$app, \$providers);

\$app->boot();

\$path = \$app['path'].'/start/global.php';
if (file_exists(\$path)) require \$path;

\$path = \$app['path']."/start/{\$env}.php";

if (file_exists(\$path)) require \$path;

require \$app['path'].'/routes.php';
AUTO
echo "done."
