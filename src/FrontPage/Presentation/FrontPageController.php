<?php declare(strict_types=1);

namespace PrPHP\FrontPage\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PrPHP\Framework\Rendering\TemplateRenderer;
use PrPHP\FrontPage\Application\SubmissionsQuery;

final class FrontPageController
{
    private $templateRenderer;
    private $submissionsQuery;

    public function __construct(TemplateRenderer $templateRenderer, SubmissionsQuery $submissionsQuery)
    {
        $this->templateRenderer = $templateRenderer;
        $this->submissionsQuery = $submissionsQuery;
    }

    public function show(Request $request): Response
    {
        $content = $this->templateRenderer->render('FrontPage.html.twig', [
            'submissions' => $this->submissionsQuery->execute(),
        ]);
        return new Response($content);
    }
}