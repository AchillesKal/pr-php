<?php declare(strict_types=1);

namespace PrPHP\FrontPage\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class FrontPageController
{
    public function show(Request $request): Response
    {
        $content = 'Hello, ' . $request->get('name', 'visitor');
        return new Response($content);
    }
}