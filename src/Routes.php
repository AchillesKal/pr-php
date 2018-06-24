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

$routes->add('submission',
    new Routing\Route('/submit',
        array(
            '_controller' => 'PrPHP\Submission\Presentation\SubmissionController::show'
        ),
        [],[],"",[],
        "GET"
    )
);

$routes->add('post_submission',
    new Routing\Route('/submit',
        array(
            '_controller' => 'PrPHP\Submission\Presentation\SubmissionController::submit'
        ),
        [],[],"",[],
        "POST"
    )
);

$routes->add('register',
    new Routing\Route('/register',
        array(
            '_controller' => 'PrPHP\User\Presentation\RegistrationController::show'
        ),
        [],[],"",[],
        "GET"
    )
);

$routes->add('register_post',
    new Routing\Route('/register',
        array(
            '_controller' => 'PrPHP\User\Presentation\RegistrationController::register'
        ),
        [],[],"",[],
        "POST"
    )
);

$routes->add('login',
    new Routing\Route('/login',
        array(
            '_controller' => 'PrPHP\User\Presentation\LoginController::show'
        ),
        [],[],"",[],
        "GET"
    )
);

$routes->add('login_post',
    new Routing\Route('/login',
        array(
            '_controller' => 'PrPHP\User\Presentation\LoginController::logIn'
        ),
        [],[],"",[],
        "POST"
    )
);

return $routes;