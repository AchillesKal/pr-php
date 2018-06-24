<?php declare(strict_types=1);

namespace PrPHP\User\Presentation;

use PrPHP\Framework\Csrf\StoredTokenValidator;
use PrPHP\User\Application\NicknameTakenQuery;
use Symfony\Component\HttpFoundation\Request;

final class RegisterUserFormFactory
{
    private $storedTokenValidator;
    private $nicknameTakenQuery;

    public function __construct(StoredTokenValidator $storedTokenValidator, NicknameTakenQuery $nicknameTakenQuery)
    {
        $this->storedTokenValidator = $storedTokenValidator;
        $this->nicknameTakenQuery = $nicknameTakenQuery;
    }
    public function createFromRequest(Request $request): RegisterUserForm
    {
        return new RegisterUserForm(
            $this->storedTokenValidator,
            (string)$request->get('token'),
            (string)$request->get('nickname'),
            (string)$request->get('password'),
            $this->nicknameTakenQuery
        );
    }
}