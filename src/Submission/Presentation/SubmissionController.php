<?php declare(strict_types=1);

namespace PrPHP\Submission\Presentation;

use PrPHP\Framework\Csrf\Token;
use PrPHP\Submission\Application\SubmitLinkHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PrPHP\Framework\Rendering\TemplateRenderer;
use PrPHP\Framework\Csrf\StoredTokenValidator;
use Symfony\Component\HttpFoundation\Session\Session;
use PrPHP\Submission\Application\SubmitLink;

final class SubmissionController
{
    private $templateRenderer;

    private $storedTokenValidator;

    private $session;

    public function __construct(
        TemplateRenderer $templateRenderer,
        StoredTokenValidator $storedTokenValidator,
        Session $session,
        SubmitLinkHandler $submitLinkHandler

    )
    {
        $this->templateRenderer = $templateRenderer;
        $this->storedTokenValidator = $storedTokenValidator;
        $this->session = $session;
        $this->submitLinkHandler = $submitLinkHandler;
    }

    public function show(): Response
    {
        $content = $this->templateRenderer->render('Submission.html.twig');
        return new Response($content);
    }

    public function submit(Request $request): Response
    {
        $response = new RedirectResponse('/submit');
        if (!$this->storedTokenValidator->validate(
            'submission',
            new Token((string)$request->get('token'))
        )) {
            $this->session->getFlashBag()->add('errors', 'Invalid token');
            return $response;
        }

        $this->submitLinkHandler->handle(new SubmitLink(
            $request->get('url'),
            $request->get('title')
        ));

        $this->session->getFlashBag()->add(
            'success',
            'Your URL was submitted successfully'
        );
        return $response;
    }
}