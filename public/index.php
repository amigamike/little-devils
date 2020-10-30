<?php

/**
 * Little Devil's Nursery Management System.
 *
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

/*
 * Define the ROOT directory.
 */
putenv("ROOT=" . __DIR__ . "/../");

/*
 * Define the templates ROOT directory.
 */
putenv("TEMPLATES_ROOT=" . __DIR__ . "/../templates/");

/*
 * Load the autoload map.
 */
require_once(getenv('ROOT') . '/vendor/autoload.php');

/*
 * Load the routes config.
 */
require_once(getenv('ROOT') . '/config/routes.php');

/*
 * Load the dotenv library.
 */
$dotenv = Dotenv\Dotenv::createImmutable(getenv('ROOT') . '/config');
$dotenv->load();
