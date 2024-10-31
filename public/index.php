<?php
/**********************************
 * Application entry file.
 * @author Alan José <alanjsdelima@gmail.com>
 * @website https://alanjose.netlify.app
 *********************************/

/*******************************
 * Helpful constants.
 ******************************/

use Core\Http\Router;

const BASE_PATH = __DIR__ . '/../';
const SERVICE_KEY_PREFIX = '_service_';

/*******************************
 * Calling autoload.
 ******************************/
require BASE_PATH . 'bootstrap/autoload.php';

/**
 * Application routing.
 */
// TODO: Check force https scheme.
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$router = new Router();

require BASE_PATH . 'routes/web.php';

$router->route($requestUri, $requestMethod);