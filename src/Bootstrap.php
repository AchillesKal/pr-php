<?php declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

\Tracy\Debugger::enable();

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$routes = new RouteCollection();

$routes->add('front_page',
    new Route('/',
        array(
            '_controller' => 'PrPHP\FrontPage\Presentation\FrontPageController::show'
        ),
        [],[],"",[],
        "GET"
    )
);

$routes->add('submition',
    new Route('/submit',
        array(
            '_controller' => 'PrPHP\Submission\Presentation\SubmissionController::show'
        )
    )
);

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    [$controllerName, $method] = explode('::', $_controller);

    $controller = new $controllerName;
    $response = $controller->$method($request, $vars);
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