<?php declare(strict_types=1);

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();

$routes->add('front_page',
    new Routing\Route('/',
        array(
            '_controller' => 'PrPHP\FrontPage\Presentation\FrontPageController::show'
        ),
        [],[],"",[],
        "GET"
    )
);

$routes->add('submition',
    new Routing\Route('/submit',
        array(
            '_controller' => 'PrPHP\Submission\Presentation\SubmissionController::show'
        )
    )
);

return $routes;