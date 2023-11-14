<?php

/**
 * @file
 * This file is included very early; see autoload.files in composer.json.
 */

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

// Load any .env file. See /.env.example.
$dotenv = Dotenv::createImmutable(__DIR__);
try {
  $dotenv->load();
}
catch (InvalidPathException $e) {
  // Do nothing. Production environments rarely use .env files.
}
