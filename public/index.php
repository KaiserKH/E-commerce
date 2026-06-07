<?php
declare(strict_types=1);

define('APP_ROOT', dirname(__DIR__));

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $path = APP_ROOT . '/app/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($path)) {
        require_once $path;
    }
});

require_once APP_ROOT . '/app/Helpers/functions.php';

use App\Core\App;
use App\Core\Config;
use App\Core\Env;
use App\Core\Session;

Env::load(APP_ROOT . '/.env');
Config::load(APP_ROOT . '/app/Config');
Session::start();

$app = new App();
$app->run();