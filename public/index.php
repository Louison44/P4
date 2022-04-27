<?php

use Router\Router;
use App\Exceptions\NotFoundException;

require '../vendor/autoload.php';

define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);
define('DB_NAME', 'myapp');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'root');

$router = new Router($_GET['url']);

$router->get('/', 'App\Controllers\BlogController@welcome');
$router->get('/posts', 'App\Controllers\BlogController@index');
$router->get('/posts/:id', 'App\Controllers\BlogController@show');

$router->get('/admin/posts', 'App\Controllers\Admin\PostController@index');

try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}