<?php
/**
 * @author EgorKluch (EgorKluch@gmail.com)
 * @date: 11.06.2014
 */

namespace Site;

require 'vendor/autoload.php';

define('ROOT_DIR', __DIR__ . '/');

spl_autoload_register(function ($class) {
  $parts = explode('\\', $class);
  if ('Site\\Airy' === $class) {
    require_once ROOT_DIR . 'Airy.php';
    return;
  }
  if ('Site' === $parts[0]) {
    $parts[0] = 'bundles';
    $path = implode('/', $parts) . '.php';
    require_once ROOT_DIR . $path;
  }
});

$config = require './config/config.php';
$app = new Airy($config);

require ROOT_DIR . 'config/routes.php';

$app->run();
