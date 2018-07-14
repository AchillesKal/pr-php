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
use PrPHP\Framework\Rbac\Permission;

final class SubmissionController
{
    private $templateRenderer;

    private $submissionFormFactory;

    private $session;

    private $user;

    public function __construct(
        TemplateRenderer $templateRenderer,
        SubmissionFormFactory $submissionFormFactory,
        Session $session,
        SubmitLinkHandler $submitLinkHandler
    )
    {
        $this->templateRenderer = $templateRenderer;
        $this->submissionFormFactory = $submissionFormFactory;
        $this->session = $session;
        $this->submitLinkHandler = $submitLinkHandler;
    }

    public function show(): Response
    {
        if (!$this->user->hasPermission(new Permission\SubmitLink())) {
            $this->session->getFlashBag()->add(
                'errors',
                'You have to log in before you can submit a link.'
            );
            return new RedirectResponse('/login');
        }

        $content = $this->templateRenderer->render('Submission.html.twig');
        return new Response($content);
    }

    public function submit(Request $request): Response
    {
        if (!$this->user->hasPermission(new Permission\SubmitLink())) {
            $this->session->getFlashBag()->add(
                'errors',
                'You have to log in before you can submit a link.'
            );
            return new RedirectResponse('/login');
        }

        $response = new RedirectResponse('/submit');

        $form = $this->submissionFormFactory->createFromRequest($request);

        if ($form->hasValidationErrors()) {
            foreach ($form->getValidationErrors() as $errorMessage) {
                $this->session->getFlashBag()->add('errors', $errorMessage);
            }
            return $response;
        }

        $this->submitLinkHandler->handle($form->toCommand());
        $this->session->getFlashBag()->add(
            'success',
            'Your URL was submitted successfully'
        );
        return $response;
    }
}