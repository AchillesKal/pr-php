<?php declare(strict_types=1);

namespace PrPHP\FrontPage\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PrPHP\Framework\Rendering\TemplateRenderer;

final class FrontPageController
{
    private $templateRenderer;

    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function show(Request $request): Response
    {
        $content = $this->templateRenderer->render('FrontPage.html.twig');
        return new Response($content);
    }
}