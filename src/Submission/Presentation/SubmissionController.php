<?php declare(strict_types=1);

namespace PrPHP\Submission\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PrPHP\Framework\Rendering\TemplateRenderer;

final class SubmissionController
{
    private $templateRenderer;

    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function show(): Response
    {
        $content = $this->templateRenderer->render('Submission.html.twig');
        return new Response($content);
    }
}