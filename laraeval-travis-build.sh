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
LARAVEL_FILE=${BUILD_DIR}/laravel-v4.0.5.tar.gz
LARAVEL_APP_DIR=${BUILD_DIR}/laravel-app
COMPOSER_PATH=${BUILD_DIR}/composer.json
PHPUNIT_CONFIG_PATH=${BUILD_DIR}/phpunit.xml
PHPUNIT_LOADER_PATH=${BUILD_DIR}/phpunit_loader.php

mkdir -p $BUILD_DIR

# Download Laravel App v4.0.5
if [ ! -f ${LARAVEL_FILE} ]; then
    wget https://github.com/laravel/laravel/archive/v4.0.5.tar.gz -O ${LARAVEL_FILE}
else
    echo "[LARAEVAL BUILD NOTICE] File ${LARAVEL_FILE} already exists, skipping download."
fi

if [ ! -d ${LARAVEL_APP_DIR} ]; then
    # extract the content of the file
    tar -zxvf ${LARAVEL_FILE} -C ${BUILD_DIR}/

    # rename it to laravel-app
    mv ${BUILD_DIR}/laravel-4.0.5 ${LARAVEL_APP_DIR}
else
    echo "[LARAEVAL BUILD NOTICE] Directory ${LARAVEL_APP_DIR} already exists, skipping extract."
fi

# cd to the laravel app
cd ${LARAVEL_APP_DIR}

# download composer if not exists
if [ ! -f ./composer.phar ]; then
    curl -sS https://getcomposer.org/installer | php
fi

# run laravel installer via composer
echo "[LARAEVAL] Installing Laravel Framework..."
php composer.phar --prefer-dist --verbose install

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
require LARAVEL_BASE_PATH . '/bootstrap/start.php';
require '${BASE_DIR}/src/models/Laraeval.php';
AUTO
echo "done."
