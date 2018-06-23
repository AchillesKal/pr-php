<?php declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

\Tracy\Debugger::enable();

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$routes = include(ROOT_DIR . '/src/Routes.php');

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    [$controllerName, $method] = explode('::', $_controller);

    $injector = include('Dependencies.php');
    $controller = $injector->make($controllerName);

    $response = $controller->$method($request);
} catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $exception) {
    $response = new \Symfony\Component\HttpFoundation\Response(
        'Not found',
        404
    );
} catch (\Symfony\Component\Routing\Exception\MethodNotAllowedException $exception) {
    $response = new \Symfony\Component\HttpFoundation\Response('Method not allowed', 500);
} catch (Exception $exception) {
    $response = new \Symfony\Component\HttpFoundation\Response('An error occurred', 500);
}

if (!$response instanceof \Symfony\Component\HttpFoundation\Response) {
    throw new \Exception('Controller methods must return a Response object');
}

$response->prepare($request);
$response->send();