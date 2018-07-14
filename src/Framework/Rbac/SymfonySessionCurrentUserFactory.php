<?php declare(strict_types=1);

namespace PrPHP\Framework\Rbac;

use Ramsey\Uuid\Uuid;
use PrPHP\Framework\Rbac\Role\Author;
use Symfony\Component\HttpFoundation\Session\Session;

final class SymfonySessionCurrentUserFactory
{
    private $session;
    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    public function create(): User
    {
        if (!$this->session->has('userId')) {
            return new Guest();
        }
        return new AuthenticatedUser(
            Uuid::fromString($this->session->get('userId')),
            [new Author()]
        );
    }
}